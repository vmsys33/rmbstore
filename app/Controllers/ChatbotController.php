<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use Config\AIProviders;

/**
 * Class ChatbotController
 * Handles chatbot functionality with Hugging Face AI integration
 */
class ChatbotController extends BaseController
{
    protected $request;
    protected $helpers = ['form'];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->request = $request;
    }

    /**
     * Get all products for chatbot
     */
    public function getProducts()
    {
        try {
            $db = \Config\Database::connect();
            $query = $db->table('products')
                       ->select('id, product_name, description, price, image_post, image_icon, product_category')
                       ->orderBy('product_name', 'ASC')
                       ->get();
            
            $products = $query->getResultArray();
            
            return $this->response->setJSON([
                'status' => 'success',
                'data' => $products
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to fetch products: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    /**
     * Enhanced product search with multiple search strategies
     */
    public function searchProducts()
    {
        try {
            $query = $this->request->getGet('q');
            $category = $this->request->getGet('category');
            $minPrice = $this->request->getGet('min_price');
            $maxPrice = $this->request->getGet('max_price');
            $sortBy = $this->request->getGet('sort_by') ?: 'relevance';
            $limit = $this->request->getGet('limit') ?: 20;
            
            if (empty($query)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Search query is required'
                ])->setStatusCode(400);
            }

            $db = \Config\Database::connect();
            $builder = $db->table('products');
            
            // Enhanced search with multiple strategies
            $builder->select('id, product_name, description, price, image_post, image_icon, product_category');
            
            // Build search query with improved matching
            $this->buildProductSearchQuery($builder, $query, $category, $minPrice, $maxPrice);
            
            // Apply sorting
            $this->applyProductSorting($builder, $sortBy);
            
            // Apply limit
            $builder->limit($limit);
            
            $results = $builder->get()->getResultArray();
            
            // Score and rank results for better relevance
            $scoredResults = $this->scoreProductResults($results, $query);
            
            // Format results for better presentation
            $formattedResults = $this->formatProductSearchResults($scoredResults);
            
            return $this->response->setJSON([
                'status' => 'success',
                'data' => $formattedResults,
                'query' => $query,
                'count' => count($formattedResults),
                'filters' => [
                    'category' => $category,
                    'min_price' => $minPrice,
                    'max_price' => $maxPrice,
                    'sort_by' => $sortBy
                ],
                'search_metadata' => [
                    'total_products' => $this->getTotalProductCount(),
                    'search_time' => microtime(true)
                ]
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Product search failed: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Search failed: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }
    
    /**
     * Build the product search query with filters
     */
    private function buildProductSearchQuery($builder, $query, $category = null, $minPrice = null, $maxPrice = null)
    {
        $query = trim($query);
        $keywords = preg_split('/\s+/', $query);
        
        // Start building the search query
        $builder->groupStart();
        
        // Strategy 1: Exact phrase match (highest priority)
        $builder->orWhere('LOWER(product_name)', strtolower($query));
        $builder->orWhere('LOWER(description)', strtolower($query));
        
        // Strategy 2: Individual keyword matches in product name
        foreach ($keywords as $keyword) {
            if (strlen($keyword) > 2) {
                $builder->orWhere('LOWER(product_name) LIKE', '%' . strtolower($keyword) . '%');
            }
        }
        
        // Strategy 3: Individual keyword matches in description
        foreach ($keywords as $keyword) {
            if (strlen($keyword) > 2) {
                $builder->orWhere('LOWER(description) LIKE', '%' . strtolower($keyword) . '%');
            }
        }
        
        $builder->groupEnd();
        
        // Apply category filter if specified
        if (!empty($category)) {
            $builder->where('category', $category);
        }
        
        // Apply price filters if specified
        if (!empty($minPrice) && is_numeric($minPrice)) {
            $builder->where('price >=', $minPrice);
        }
        
        if (!empty($maxPrice) && is_numeric($maxPrice)) {
            $builder->where('price <=', $maxPrice);
        }
        
        // Note: stock_quantity column doesn't exist, so we can't filter by stock
    }
    
    /**
     * Apply sorting to product search results
     */
    private function applyProductSorting($builder, $sortBy)
    {
        switch ($sortBy) {
            case 'price_low':
                $builder->orderBy('price', 'ASC');
                break;
            case 'price_high':
                $builder->orderBy('price', 'DESC');
                break;
            case 'name_asc':
                $builder->orderBy('product_name', 'ASC');
                break;
            case 'name_desc':
                $builder->orderBy('product_name', 'DESC');
                break;
            case 'newest':
                $builder->orderBy('id', 'DESC'); // Using ID as proxy for creation date
                break;
            case 'oldest':
                $builder->orderBy('id', 'ASC'); // Using ID as proxy for creation date
                break;
            default: // relevance - will be sorted after scoring
                $builder->orderBy('product_name', 'ASC');
                break;
        }
    }
    
    /**
     * Score product search results for better relevance
     */
    private function scoreProductResults($results, $query)
    {
        $scoredResults = [];
        $queryLower = strtolower($query);
        
        foreach ($results as $result) {
            $score = 0;
            $productNameLower = strtolower($result['product_name']);
            $descriptionLower = strtolower($result['description']);
            
            // Exact match gets highest score
            if ($productNameLower === $queryLower) {
                $score += 100;
            } elseif (strpos($productNameLower, $queryLower) !== false) {
                $score += 80;
            }
            
            // Description match gets medium score
            if (strpos($descriptionLower, $queryLower) !== false) {
                $score += 40;
            }
            
            // Keyword matching
            $keywords = explode(' ', $queryLower);
            foreach ($keywords as $keyword) {
                if (strlen($keyword) > 2) {
                    if (strpos($productNameLower, $keyword) !== false) {
                        $score += 30;
                    }
                    if (strpos($descriptionLower, $keyword) !== false) {
                        $score += 15;
                    }
                }
            }
            
            // Stock availability bonus (stock_quantity column doesn't exist)
            // Assume all products are in stock for scoring purposes
            $score += 10;
            
            $scoredResults[] = [
                'product' => $result,
                'score' => $score
            ];
        }
        
        // Sort by score (highest first)
        usort($scoredResults, function($a, $b) {
            return $b['score'] - $a['score'];
        });
        
        return $scoredResults;
    }
    
    /**
     * Format product search results for better presentation
     */
    private function formatProductSearchResults($scoredResults)
    {
        $formatted = [];
        
        foreach ($scoredResults as $item) {
            $product = $item['product'];
            $formatted[] = [
                'id' => $product['id'],
                'product_name' => $product['product_name'], // Keep original property name for frontend compatibility
                'name' => $product['product_name'], // Also add 'name' for flexibility
                'description' => $this->truncateDescription($product['description'], 150),
                'price' => $product['price'], // Keep original price for proper formatting
                'image_post' => $product['image_post'], // Include actual product image
                'image_icon' => $product['image_icon'], // Include icon image
                'product_category' => $product['product_category'], // Include category
                'stock_status' => 'in_stock', // Assume all products are in stock
                'relevance_score' => $item['score'],
                'url' => base_url('product/' . $product['id']) // Fix URL format
            ];
        }
        
        return $formatted;
    }
    
    /**
     * Truncate description to specified length
     */
    private function truncateDescription($description, $length)
    {
        if (strlen($description) <= $length) {
            return $description;
        }
        
        return substr($description, 0, $length) . '...';
    }
    

    
    /**
     * Get total product count for search metadata
     */
    private function getTotalProductCount()
    {
        try {
            $db = \Config\Database::connect();
            return $db->table('products')->countAllResults();
        } catch (\Exception $e) {
            return 0;
        }
    }
    
    /**
     * Get product search suggestions for autocomplete
     */
    public function getProductSuggestions()
    {
        try {
            $query = $this->request->getGet('q');
            $limit = $this->request->getGet('limit') ?: 10;
            
            if (empty($query) || strlen($query) < 2) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'data' => [],
                    'query' => $query
                ]);
            }
            
            $db = \Config\Database::connect();
            $builder = $db->table('products');
            
            // Get product name suggestions
            $nameSuggestions = $builder->select('product_name as suggestion, "product_name" as type')
                                     ->like('product_name', '%' . $query . '%')
                                     ->limit($limit)
                                     ->get()
                                     ->getResultArray();
            
            // Get category suggestions if category column exists
            $categorySuggestions = [];
            try {
                $categorySuggestions = $db->table('products')
                                        ->select('DISTINCT(category) as suggestion, "category" as type')
                                        ->like('category', '%' . $query . '%')
                                        ->where('category IS NOT NULL')
                                        ->where('category !=', '')
                                        ->limit(5)
                                        ->get()
                                        ->getResultArray();
            } catch (\Exception $e) {
                // Category column might not exist
                log_message('info', 'Category suggestions not available: ' . $e->getMessage());
            }
            
            // Combine and format suggestions
            $suggestions = array_merge($nameSuggestions, $categorySuggestions);
            
            // Remove duplicates and limit results
            $uniqueSuggestions = [];
            $seen = [];
            foreach ($suggestions as $suggestion) {
                $key = strtolower($suggestion['suggestion']);
                if (!isset($seen[$key])) {
                    $seen[$key] = true;
                    $uniqueSuggestions[] = $suggestion;
                }
            }
            
            // Limit to requested number
            $uniqueSuggestions = array_slice($uniqueSuggestions, 0, $limit);
            
            return $this->response->setJSON([
                'status' => 'success',
                'data' => $uniqueSuggestions,
                'query' => $query,
                'count' => count($uniqueSuggestions)
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Product suggestions failed: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to get suggestions: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }
    
    /**
     * Get product categories for filtering
     */
    public function getProductCategories()
    {
        try {
            $db = \Config\Database::connect();
            
            // Try to get categories from products table
            try {
                $categories = $db->table('products')
                                ->select('DISTINCT(category) as name, COUNT(*) as product_count')
                                ->where('category IS NOT NULL')
                                ->where('category !=', '')
                                ->groupBy('category')
                                ->orderBy('product_count', 'DESC')
                                ->get()
                                ->getResultArray();
            } catch (\Exception $e) {
                // If category column doesn't exist, return default categories
                log_message('info', 'Category column not found, using defaults: ' . $e->getMessage());
                $categories = [
                    ['name' => 'Electronics', 'product_count' => 0],
                    ['name' => 'Fashion', 'product_count' => 0],
                    ['name' => 'Accessories', 'product_count' => 0],
                    ['name' => 'Smartphones', 'product_count' => 0],
                    ['name' => 'Laptops', 'product_count' => 0]
                ];
            }
            
            return $this->response->setJSON([
                'status' => 'success',
                'data' => $categories
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to get product categories: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to get categories: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }
    
    /**
     * Get product price range for filtering
     */
    public function getProductPriceRange()
    {
        try {
            $db = \Config\Database::connect();
            
            $priceRange = $db->table('products')
                            ->select('MIN(price) as min_price, MAX(price) as max_price')
                            ->get()
                            ->getRowArray();
            
            return $this->response->setJSON([
                'status' => 'success',
                'data' => [
                    'min_price' => floatval($priceRange['min_price'] ?? 0),
                    'max_price' => floatval($priceRange['max_price'] ?? 1000)
                ]
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to get price range: ' . $e->getMessage());
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to get price range: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    /**
     * Get Q&A data
     */
    public function getQA()
    {
        try {
            $db = \Config\Database::connect();
            $query = $db->table('chatbot_faq')
                       ->select('*')
                       ->where('is_active', 1)
                       ->orderBy('priority', 'DESC')
                       ->orderBy('category', 'ASC')
                       ->get();
            
            $qa = $query->getResultArray();
            
            return $this->response->setJSON([
                'status' => 'success',
                'data' => $qa
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to fetch Q&A: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    /**
     * Search Q&A based on query
     */
    public function searchQA()
    {
        try {
            $query = $this->request->getGet('q');
            if (empty($query)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Search query is required'
                ])->setStatusCode(400);
            }

            $db = \Config\Database::connect();
            $builder = $db->table('chatbot_faq');
            
            $results = $builder->select('*')
                             ->where('is_active', 1)
                             ->groupStart()
                             ->like('query', '%' . $query . '%')
                             ->orLike('response', '%' . $query . '%')
                             ->orLike('keywords', '%' . $query . '%')
                             ->groupEnd()
                             ->orderBy('priority', 'DESC')
                             ->orderBy('category', 'ASC')
                             ->get()
                             ->getResultArray();

            return $this->response->setJSON([
                'status' => 'success',
                'data' => $results,
                'query' => $query,
                'count' => count($results)
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Q&A search failed: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    /**
     * Generate chatbot response with mode-based intelligent search system
     */
    public function generateResponse()
    {
        try {
            $input = $this->request->getJSON();
            
            if (!isset($input->message) || !isset($input->sessionId)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Message and session ID are required'
                ])->setStatusCode(400);
            }

            $message = $input->message;
            $sessionId = $input->sessionId;
            $userName = $input->userName ?? null;
            $userEmail = $input->userEmail ?? null;

            // Save or update user information
            $userId = $this->saveUserInfo($sessionId, $userName, $userEmail);
            
            // Save user message
            $this->saveMessage($sessionId, $userId, 'user', $message);

            // MODE-BASED INTELLIGENT SEARCH SYSTEM
            
            // Get the search mode from the request
            $searchMode = $input->searchMode ?? 'auto'; // 'auto', 'products', 'store'
            log_message('info', 'Chatbot searching in mode: ' . $searchMode . ' for message: ' . $message);
            
            // Step 1: Handle based on search mode
            if ($searchMode === 'products') {
                // PRODUCT SEARCH MODE - Only search products
                log_message('info', 'Product search mode activated for: ' . $message);
                $products = $this->searchProductsForMessage($message);
                
                if (!empty($products)) {
                    log_message('info', 'Found ' . count($products) . ' products in product mode');
                    $formattedProducts = $this->formatProductSearchResults($this->scoreProductResults($products, $message));
                    $this->saveMessage($sessionId, $userId, 'bot', 'Product search results (product mode)');
                    
                    return $this->response->setJSON([
                        'status' => 'success',
                        'response' => 'I found some products that match your search!',
                        'type' => 'product_results',
                        'mode' => 'products',
                        'products' => $formattedProducts,
                        'query' => $message,
                        'count' => count($formattedProducts)
                    ]);
                } else {
                    log_message('info', 'No products found in product mode for: ' . $message);
                    
                    // Check if the query is unclear and needs confirmation
                    if (strlen($message) < 5 || $this->isUnclearQuery($message)) {
                        $confirmationResponse = $this->getQueryConfirmationResponse($message);
                        $this->saveMessage($sessionId, $userId, 'bot', $confirmationResponse);
                        
                        return $this->response->setJSON([
                            'status' => 'success',
                            'response' => $confirmationResponse,
                            'type' => 'query_confirmation',
                            'mode' => 'products',
                            'query' => $message
                        ]);
                    }
                    
                    $this->saveMessage($sessionId, $userId, 'bot', 'No products found');
                    
                    return $this->response->setJSON([
                        'status' => 'success',
                        'response' => "I couldn't find any products matching \"{$message}\". Try searching with different keywords or browse our categories.",
                        'type' => 'no_products_found',
                        'mode' => 'products',
                        'query' => $message
                    ]);
                }
                
            } elseif ($searchMode === 'store') {
                // STORE INQUIRY MODE - Only search FAQ and provide store info
                log_message('info', 'Store inquiry mode activated for: ' . $message);
                $faqResult = $this->searchFAQ($message);
                
                if (!empty($faqResult)) {
                    log_message('info', 'Found FAQ match in store mode: ' . $faqResult['query']);
                    $formattedResponse = $this->formatFAQResponse($faqResult['response'], $faqResult['category']);
                    $this->saveMessage($sessionId, $userId, 'bot', $formattedResponse);
                    
                    return $this->response->setJSON([
                        'status' => 'success',
                        'response' => $formattedResponse,
                        'type' => 'faq_response',
                        'mode' => 'store',
                        'faq_id' => $faqResult['id']
                    ]);
                } else {
                    // Try AI for store-related questions
                    log_message('info', 'No FAQ match in store mode, using AI for: ' . $message);
                    $aiResponse = $this->getGoogleAIResponse($message, $sessionId, $userId);
                    
                    if ($aiResponse && !empty(trim($aiResponse)) && $aiResponse !== 'RATE_LIMIT_EXCEEDED') {
                        $formattedResponse = $this->formatAIResponse($aiResponse, $message);
                        $this->saveMessage($sessionId, $userId, 'bot', $formattedResponse);
                        
                        return $this->response->setJSON([
                            'status' => 'success',
                            'response' => $formattedResponse,
                            'type' => 'ai_response',
                            'mode' => 'store',
                            'provider' => 'google_ai'
                        ]);
                    } else {
                        // Smart fallback for store mode
                        $fallbackResponse = $this->getStoreInquiryFallback($message);
                        $this->saveMessage($sessionId, $userId, 'bot', $fallbackResponse);
                        
                        return $this->response->setJSON([
                            'status' => 'success',
                            'response' => $fallbackResponse,
                            'type' => 'store_fallback',
                            'mode' => 'store'
                        ]);
                    }
                }
                
            } else {
                // AUTO MODE - Intelligent detection (existing logic)
                log_message('info', 'Auto mode activated, using intelligent detection for: ' . $message);
                
                // Step 1: Search FAQ table first (highest priority)
                log_message('info', 'Starting FAQ search for message: ' . $message);
                $faqResult = $this->searchFAQ($message);
                if (!empty($faqResult)) {
                    log_message('info', 'Found FAQ match: ' . $faqResult['query']);
                    $formattedResponse = $this->formatFAQResponse($faqResult['response'], $faqResult['category']);
                    $this->saveMessage($sessionId, $userId, 'bot', $formattedResponse);
                    
                    return $this->response->setJSON([
                        'status' => 'success',
                        'response' => $formattedResponse,
                        'type' => 'faq_response',
                        'mode' => 'auto',
                        'faq_id' => $faqResult['id']
                    ]);
                }
                
                // Step 2: Check if this is a product search query
                if ($this->isProductSearch($message)) {
                    log_message('info', 'Detected product search query: ' . $message);
                    $products = $this->searchProductsForMessage($message);
                    
                    if (!empty($products)) {
                        log_message('info', 'Found ' . count($products) . ' products, returning product results');
                        $formattedProducts = $this->formatProductSearchResults($this->scoreProductResults($products, $message));
                        $this->saveMessage($sessionId, $userId, 'bot', 'Product search results');
                        
                        return $this->response->setJSON([
                            'status' => 'success',
                            'response' => 'I found some products that match your search!',
                            'type' => 'product_results',
                            'mode' => 'auto',
                            'products' => $formattedProducts,
                            'query' => $message,
                            'count' => count($formattedProducts)
                        ]);
                    }
                }
                
                // Step 3: Use AI response (Google AI)
                log_message('info', 'No FAQ match, using AI response for: ' . $message);
                $aiResponse = $this->getGoogleAIResponse($message, $sessionId, $userId);
                
                if ($aiResponse && !empty(trim($aiResponse)) && $aiResponse !== 'RATE_LIMIT_EXCEEDED') {
                    log_message('info', 'Google AI response is valid, formatting...');
                    $formattedResponse = $this->formatAIResponse($aiResponse, $message);
                    $this->saveMessage($sessionId, $userId, 'bot', $formattedResponse);
                    
                    return $this->response->setJSON([
                        'status' => 'success',
                        'response' => $formattedResponse,
                        'type' => 'ai_response',
                        'mode' => 'auto',
                        'provider' => 'google_ai'
                    ]);
                }
                
                // Step 4: Try Hugging Face as fallback
                log_message('info', 'Google AI failed, trying Hugging Face for: ' . $message);
                $huggingFaceResponse = $this->getHuggingFaceResponseOriginal($message, $sessionId, $userId);
                
                if ($huggingFaceResponse && !empty(trim($huggingFaceResponse))) {
                    log_message('info', 'Hugging Face response received, formatting...');
                    $formattedResponse = $this->formatAIResponse($huggingFaceResponse, $message);
                    $this->saveMessage($sessionId, $userId, 'bot', $formattedResponse);
                    
                    return $this->response->setJSON([
                        'status' => 'success',
                        'response' => $formattedResponse,
                        'type' => 'ai_response',
                        'mode' => 'auto',
                        'provider' => 'hugging_face'
                    ]);
                }
                
                // Step 5: Smart fallback based on message type
                $fallbackResponse = $this->getSmartFallbackResponse($message);
                $this->saveMessage($sessionId, $userId, 'bot', $fallbackResponse);
                
                return $this->response->setJSON([
                    'status' => 'success',
                    'response' => $fallbackResponse,
                    'type' => 'smart_fallback',
                    'mode' => 'auto'
                ]);
            }
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Response generation failed: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    /**
     * Save user information
     */
    private function saveUserInfo($sessionId, $userName, $userEmail)
    {
        try {
            $db = \Config\Database::connect();
            
            // Check if user exists
            $existingUser = $db->table('chatbot_users')
                              ->where('session_id', $sessionId)
                              ->get()
                              ->getRowArray();
            
            if ($existingUser) {
                // Update existing user
                $db->table('chatbot_users')
                   ->where('session_id', $sessionId)
                   ->update([
                       'user_name' => $userName ?: $existingUser['user_name'],
                       'user_email' => $userEmail ?: $existingUser['user_email'],
                       'updated_at' => date('Y-m-d H:i:s')
                   ]);
                return $existingUser['id'];
            } else {
                // Create new user
                $data = [
                    'session_id' => $sessionId,
                    'user_name' => $userName,
                    'user_email' => $userEmail,
                    'ip_address' => $this->request->getIPAddress(),
                    'user_agent' => $this->request->getUserAgent()->getAgentString(),
                    'created_at' => date('Y-m-d H:i:s')
                ];
                
                $db->table('chatbot_users')->insert($data);
                return $db->insertID();
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to save user info: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Save message to database
     */
    private function saveMessage($sessionId, $userId, $type, $content, $ciciUsed = false, $ciciResponse = null)
    {
        try {
            $db = \Config\Database::connect();
            
            $data = [
                'session_id' => $sessionId,
                'user_id' => $userId,
                'message_type' => $type,
                'message_content' => $content,
                'cici_ai_used' => $ciciUsed,
                'cici_ai_response' => $ciciResponse,
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $db->table('chatbot_messages')->insert($data);
            
            // Update session message count
            $this->updateSessionMessageCount($sessionId);
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to save message: ' . $e->getMessage());
        }
    }

    /**
     * Update session message count
     */
    private function updateSessionMessageCount($sessionId)
    {
        try {
            $db = \Config\Database::connect();
            
            $messageCount = $db->table('chatbot_messages')
                              ->where('session_id', $sessionId)
                              ->countAllResults();
            
            $db->table('chatbot_sessions')
               ->where('session_id', $sessionId)
               ->update([
                   'total_messages' => $messageCount,
                   'last_message_at' => date('Y-m-d H:i:s')
               ]);
               
        } catch (\Exception $e) {
            log_message('error', 'Failed to update session count: ' . $e->getMessage());
        }
    }

    /**
     * Check if message is a product search
     */
    private function isProductSearch($message)
    {
        $message = strtolower($message);
        
        // Skip obvious non-product messages first
        $nonProductPhrases = [
            'what', 'when', 'where', 'why', 'how', 'time', 'date', 'weather',
            'hello', 'hi', 'hey', 'good morning', 'good afternoon', 'good evening',
            'thank you', 'thanks', 'bye', 'goodbye', 'see you', 'help', 'support'
        ];
        
        foreach ($nonProductPhrases as $phrase) {
            if (strpos($message, $phrase) !== false) {
                // Check if it's a general question that shouldn't trigger product search
                if (in_array($phrase, ['what', 'when', 'where', 'why', 'how', 'time', 'date', 'weather'])) {
                    // Only allow product search if it's clearly about products
                    $productIndicators = ['product', 'item', 'goods', 'merchandise', 'stock', 'inventory'];
                    $hasProductContext = false;
                    foreach ($productIndicators as $indicator) {
                        if (strpos($message, $indicator) !== false) {
                            $hasProductContext = true;
                            break;
                        }
                    }
                    if (!$hasProductContext) {
                        return false; // This is a general question, not product search
                    }
                }
            }
        }
        
        // Product-related keywords - more specific list
        $productKeywords = [
            'macbook', 'laptop', 'iphone', 'phone', 'nike', 'shoes', 'headphones', 
            'earbuds', 'computer', 'tablet', 'watch', 'camera', 'speaker', 'adidas',
            'search for', 'looking for', 'need to buy', 'want to buy', 'purchase',
            'sell', 'carry', 'offer', 'show me', 'display', 'list of products'
        ];
        
        foreach ($productKeywords as $keyword) {
            if (strpos($message, $keyword) !== false) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Check if message is a product inquiry (question about products)
     */
    private function isProductInquiry($message)
    {
        $message = strtolower($message);
        
        // Skip obvious non-product messages
        $nonProductPhrases = [
            'hello', 'hi', 'hey', 'good morning', 'good afternoon', 'good evening',
            'how are you', 'thank you', 'thanks', 'bye', 'goodbye', 'see you',
            'help', 'support', 'contact', 'email', 'phone', 'address',
            'just want to ask', 'just asking', 'general question', 'general inquiry'
        ];
        
        foreach ($nonProductPhrases as $phrase) {
            if (strpos($message, $phrase) !== false) {
                return false;
            }
        }
        
        // Check for product-related questions
        $productQuestionKeywords = [
            'do you have', 'do you sell', 'do you carry', 'do you offer',
            'what', 'how', 'when', 'where', 'why', 'can', 'could', 'would', 'should',
            'price', 'cost', 'stock', 'available', 'in stock', 'model', 'brand',
            'specs', 'specifications', 'features', 'good', 'best', 'better'
        ];
        
        foreach ($productQuestionKeywords as $keyword) {
            if (strpos($message, $keyword) !== false) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Save product inquiry
     */
    private function saveProductInquiry($userId, $sessionId, $query)
    {
        try {
            $db = \Config\Database::connect();
            
            $data = [
                'user_id' => $userId,
                'session_id' => $sessionId,
                'product_query' => $query,
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $db->table('user_product_inquiries')->insert($data);
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to save product inquiry: ' . $e->getMessage());
        }
    }

    /**
     * Search FAQ table for matching queries
     */
    private function searchFAQ($message)
    {
        try {
            $db = \Config\Database::connect();
            
            $message = strtolower(trim($message));
            
            // Moderate matching - exact matches first, then close matches
            $builder = $db->table('chatbot_faq');
            $builder->select('id, query, response, category, priority');
            $builder->where('is_active', 1);
            
            // Strategy 1: Exact phrase match (highest priority)
            $builder->groupStart();
            $builder->where('LOWER(query)', $message);
            
            // Strategy 2: Very close matches (query contains the full message or vice versa)
            $builder->orWhere('LOWER(query) LIKE', '%' . $message . '%');
            $builder->orWhere('LOWER(query) LIKE', $message . '%');
            $builder->orWhere('LOWER(query) LIKE', '%' . $message);
            $builder->groupEnd();
            
            $results = $builder->get()->getResultArray();
            
            if (empty($results)) {
                return null;
            }
            
            // Return the first match (simple approach like the original)
            return $results[0];
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to search FAQ: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Check if user query is about location
     */
    private function isLocationQuery($message)
    {
        $locationKeywords = ['where', 'location', 'address', 'located', 'place', 'find', 'directions', 'map', 'can i find', 'find your', 'find the'];
        foreach ($locationKeywords as $keyword) {
            if (strpos($message, $keyword) !== false) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Check if FAQ is about location
     */
    private function isLocationFAQ($query)
    {
        $locationKeywords = ['location', 'address', 'where', 'store location', 'store address'];
        foreach ($locationKeywords as $keyword) {
            if (strpos(strtolower($query), $keyword) !== false) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Check if user query is about hours
     */
    private function isHoursQuery($message)
    {
        $hoursKeywords = ['when', 'hours', 'time', 'open', 'close', 'business', 'schedule'];
        foreach ($hoursKeywords as $keyword) {
            if (strpos($message, $keyword) !== false) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Check if FAQ is about hours
     */
    private function isHoursFAQ($query)
    {
        $hoursKeywords = ['hours', 'time', 'when'];
        foreach ($hoursKeywords as $keyword) {
            if (strpos(strtolower($query), $keyword) !== false) {
                return true;
            }
        }
        return false;
    }

    /**
     * Format FAQ response with proper HTML styling
     */
    private function formatFAQResponse($response, $category)
    {
        // Clean up the response - remove any leading question marks or unwanted characters
        $formatted = trim($response);
        $formatted = preg_replace('/^\?+\s*/', '', $formatted); // Remove leading question marks
        $formatted = preg_replace('/^\*\s*/', '', $formatted); // Remove leading asterisks
        $formatted = preg_replace('/^-\s*/', '', $formatted); // Remove leading dashes
        $formatted = preg_replace('/^\s+/', '', $formatted); // Remove leading whitespace
        
        // Convert \n to proper line breaks and format the response
        $formatted = str_replace('\n', '<br>', $formatted);
        
        // Add category-specific styling
        $categoryIcon = $this->getCategoryIcon($category);
        $categoryColor = $this->getCategoryColor($category);
        
        // Create a beautiful formatted response
        $html = '<div class="faq-response" style="background: linear-gradient(135deg, ' . $categoryColor . '15, ' . $categoryColor . '05); border-left: 4px solid ' . $categoryColor . '; padding: 15px; border-radius: 8px; margin: 10px 0;">';
        $html .= '<div style="display: flex; align-items: center; margin-bottom: 10px;">';
        $html .= '<span style="font-size: 20px; margin-right: 10px;">' . $categoryIcon . '</span>';
        $html .= '<span style="font-weight: 600; color: ' . $categoryColor . '; text-transform: uppercase; font-size: 12px; letter-spacing: 1px;">' . ucfirst($category) . '</span>';
        $html .= '</div>';
        $html .= '<div style="color: #333; line-height: 1.6; font-size: 14px;">' . $formatted . '</div>';
        $html .= '</div>';
        
        return $html;
    }

    /**
     * Get icon for FAQ category
     */
    private function getCategoryIcon($category)
    {
        $icons = [
            'store_info' => '🏪',
            'policies' => '📋',
            'services' => '🔧',
            'products' => '📱',
            'general' => 'ℹ️'
        ];
        
        return $icons[$category] ?? 'ℹ️';
    }

    /**
     * Get color for FAQ category
     */
    private function getCategoryColor($category)
    {
        $colors = [
            'store_info' => '#2196F3', // Blue
            'policies' => '#FF9800',   // Orange
            'services' => '#4CAF50',   // Green
            'products' => '#9C27B0',   // Purple
            'general' => '#607D8B'     // Blue Grey
        ];
        
        return $colors[$category] ?? '#607D8B';
    }

    /**
     * Search products for a message
     */
    private function searchProductsForMessage($message)
    {
        try {
            $db = \Config\Database::connect();
            
            // Improved product search - prioritize exact matches
            $message = strtolower($message);
            
            // Extract meaningful keywords (filter out common words)
            $commonWords = ['the', 'a', 'an', 'and', 'or', 'but', 'in', 'on', 'at', 'to', 'for', 'of', 'with', 'by', 'do', 'you', 'have', 'are', 'is', 'what', 'how', 'when', 'where', 'why'];
            $keywords = preg_split('/\s+/', trim($message));
            $keywords = array_filter($keywords, function($word) use ($commonWords) {
                return !empty($word) && strlen($word) > 1 && !in_array($word, $commonWords);
            });
            
            if (empty($keywords)) {
                return [];
            }
            
            $builder = $db->table('products');
            $builder->select('id, product_name, description, price, image_post, image_icon, product_category');
            
            // First, try exact matches in product names (highest priority)
            $exactMatches = $builder->like('product_name', '%' . implode('%', $keywords) . '%')->get()->getResultArray();
            
            if (!empty($exactMatches)) {
                return $exactMatches;
            }
            
            // If no exact matches, try individual keyword matches in product names
            $builder->resetQuery();
            $builder->select('id, product_name, description, price, image_post, image_icon, product_category');
            $builder->groupStart();
            foreach ($keywords as $keyword) {
                $builder->orLike('product_name', '%' . $keyword . '%');
            }
            $builder->groupEnd();
            
            $results = $builder->get()->getResultArray();
            
            // If still no results, try description matches as last resort
            if (empty($results)) {
                $builder->resetQuery();
                $builder->select('id, product_name, description, price');
                $builder->groupStart();
                foreach ($keywords as $keyword) {
                    $builder->orLike('description', '%' . $keyword . '%');
                }
                $builder->groupEnd();
                $results = $builder->get()->getResultArray();
            }
            
            return $results;
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to search products: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get CICI AI response
     */
    private function getCiciAIResponse($message, $sessionId, $userId)
    {
        try {
            // CICI AI API configuration
            $apiKey = getenv('CICI_AI_API_KEY') ?: 'your_cici_ai_api_key_here';
            $apiUrl = getenv('CICI_AI_API_URL') ?: 'https://api.cici.ai/v1/chat/completions';
            
            $startTime = microtime(true);
            
            $data = [
                'model' => 'cici-1.0',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a helpful customer service chatbot for RMB Store, an electronics and fashion retailer. Help customers find products, answer questions, and provide excellent service.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $message
                    ]
                ],
                'max_tokens' => 150,
                'temperature' => 0.7
            ];
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $apiKey,
                'Content-Type: application/json'
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            $endTime = microtime(true);
            $responseTime = round(($endTime - $startTime) * 1000); // Convert to milliseconds
            
            if ($httpCode === 200 && $response) {
                $result = json_decode($response, true);
                
                if (isset($result['choices'][0]['message']['content'])) {
                    $aiResponse = $result['choices'][0]['message']['content'];
                    
                    // Log CICI AI interaction
                    $this->logCiciAIInteraction($sessionId, $userId, $message, $aiResponse, $responseTime);
                    
                    return $aiResponse;
                }
            }
            
            return null;
            
        } catch (\Exception $e) {
            log_message('error', 'CICI AI request failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Log CICI AI interaction
     */
    private function logCiciAIInteraction($sessionId, $userId, $query, $response, $responseTime)
    {
        try {
            $db = \Config\Database::connect();
            
            $data = [
                'session_id' => $sessionId,
                'user_id' => $userId,
                'user_query' => $query,
                'cici_ai_response' => $response,
                'response_time_ms' => $responseTime,
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $db->table('cici_ai_logs')->insert($data);
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to log CICI AI interaction: ' . $e->getMessage());
        }
    }

    // Fallback method removed - now using simple AI responses

    /**
     * Format product response
     */
    private function formatProductResponse($products, $query)
    {
        $count = count($products);
        
        if ($count === 0) {
            return "I couldn't find any products matching \"$query\". Try searching with different keywords or browse our categories.";
        }
        
        if ($count === 1) {
            $product = $products[0];
            return "I found 1 product matching \"$query\":\n\n" .
                   "📱 **{$product['product_name']}**\n" .
                   "💰 Price: \${$product['price']}\n\n" .
                   "Would you like to know more about this product?";
        }
        
        $response = "I found {$count} products matching \"$query\":\n\n";
        
        foreach (array_slice($products, 0, 3) as $product) {
            $response .= "📱 **{$product['product_name']}** - \${$product['price']}\n";
        }
        
        if ($count > 3) {
            $response .= "\n... and " . ($count - 3) . " more products.\n";
        }
        
        $response .= "\nWould you like me to show you more details about any specific product?";
        
        return $response;
    }

    /**
     * Save session
     */
    public function saveSession()
    {
        try {
            $input = $this->request->getJSON();
            
            if (!isset($input->sessionId)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Session ID is required'
                ])->setStatusCode(400);
            }

            $sessionId = $input->sessionId;
            $status = $input->status ?? 'active';
            
            $db = \Config\Database::connect();
            
            // Check if session exists
            $existingSession = $db->table('chatbot_sessions')
                                ->where('session_id', $sessionId)
                                ->get()
                                ->getRowArray();
            
            if ($existingSession) {
                // Update existing session
                $db->table('chatbot_sessions')
                   ->where('session_id', $sessionId)
                   ->update([
                       'status' => $status,
                       'last_message_at' => date('Y-m-d H:i:s')
                   ]);
            } else {
                // Create new session
                $data = [
                    'session_id' => $sessionId,
                    'status' => $status,
                    'created_at' => date('Y-m-d H:i:s')
                ];
                
                $db->table('chatbot_sessions')->insert($data);
            }
            
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Session saved successfully'
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to save session: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    /**
     * Get chat history for a session
     */
    public function getChatHistory()
    {
        try {
            $sessionId = $this->request->getGet('sessionId');
            
            if (empty($sessionId)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Session ID is required'
                ])->setStatusCode(400);
            }

            $db = \Config\Database::connect();
            
            $messages = $db->table('chatbot_messages')
                          ->select('message_type, message_content, created_at')
                          ->where('session_id', $sessionId)
                          ->orderBy('created_at', 'ASC')
                          ->get()
                          ->getResultArray();
            
            return $this->response->setJSON([
                'status' => 'success',
                'data' => $messages
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to get chat history: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    /**
     * Get AI response from multiple providers (Hugging Face, Google AI, etc.)
     */
    private function getHuggingFaceResponse($message, $sessionId, $userId)
    {
        log_message('info', 'Starting AI provider selection for message: ' . $message);
        
        // Try Google AI first (if enabled)
        log_message('info', 'Checking if Google AI is enabled...');
        $isGoogleEnabled = AIProviders::isProviderEnabled('google_ai');
        log_message('info', 'Google AI enabled status: ' . ($isGoogleEnabled ? 'TRUE' : 'FALSE'));
        
        if ($isGoogleEnabled) {
            log_message('info', 'Attempting Google AI response...');
            $aiResponse = $this->getGoogleAIResponse($message, $sessionId, $userId);
            if ($aiResponse) {
                log_message('info', 'Google AI provided a response: ' . substr($aiResponse, 0, 100) . '...');
                return $aiResponse;
            }
            log_message('info', 'Google AI did not provide a response or is disabled.');
        } else {
            log_message('info', 'Google AI is disabled in configuration, skipping...');
        }
        
        // Fallback to Hugging Face
        log_message('info', 'Using Hugging Face AI...');
        $aiResponse = $this->getHuggingFaceResponseOriginal($message, $sessionId, $userId);
        if ($aiResponse) {
            log_message('info', 'Hugging Face (Original) provided a response.');
            return $aiResponse;
        }
        log_message('info', 'Hugging Face (Original) did not provide a response or is disabled.');
        
        // Final fallback to alternative Hugging Face model
        log_message('info', 'Attempting Hugging Face (Alternative) response...');
        $aiResponse = $this->getAlternativeHuggingFaceResponse($message, $sessionId, $userId, 0);
        if ($aiResponse) {
            log_message('info', 'Hugging Face (Alternative) provided a response.');
            return $aiResponse;
        }
        log_message('info', 'Hugging Face (Alternative) did not provide a response or is disabled.');
        
        return null;
    }
    
    /**
     * Get Google AI response using the working integration code with store context
     */
    private function getGoogleAIResponse($message, $sessionId, $userId)
    {
        try {
            log_message('info', 'Starting Google AI request for message: ' . $message);
            
            // Google AI API Configuration - Using the working code
            $apiKey = 'AIzaSyDnZ0FYhbTI20V72-zJ8KfYB_qV3p_zy-o';
            $apiUrl = 'https://generativelanguage.googleapis.com/v1/models/gemini-1.5-flash:generateContent';
            
            // Create a comprehensive system prompt with store context
            $systemPrompt = "You are a helpful customer service chatbot for RMB Store, a retail business. Your role is to assist customers with questions and provide helpful information. Always respond as if you work for and represent RMB Store. Be friendly, professional, and helpful. 

For general questions (like time, weather, etc.), provide a helpful answer first, then gently mention how you can help with store-related matters. For store-specific questions, provide detailed, accurate information.

Keep responses concise (2-3 sentences) and always maintain a helpful, customer-service oriented tone. Be genuinely helpful with all questions, not just store-related ones.

IMPORTANT: For time questions, you can provide the current server time or explain that you don't have real-time access, but always be helpful and friendly.";
            
            // Combine system prompt with user message
            $fullPrompt = $systemPrompt . "\n\nCustomer Question: " . $message . "\n\nYour response as RMB Store chatbot:";
            
            log_message('info', 'Full prompt length: ' . strlen($fullPrompt));
            
            // Prepare the request data for Google AI API
            $postData = [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $fullPrompt
                            ]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'topK' => 40,
                    'topP' => 0.95,
                    'maxOutputTokens' => 1024,
                ]
            ];

            log_message('info', 'Making API call to Google AI...');
            
            // Make the API call to Google AI
            $ch = curl_init($apiUrl . '?key=' . $apiKey);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json'
            ]);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);

            log_message('info', 'Google AI API response - HTTP Code: ' . $httpCode . ', Response length: ' . strlen($response));

            if ($curlError) {
                log_message('error', 'cURL error: ' . $curlError);
                return null;
            }

            if ($httpCode === 200) {
                $result = json_decode($response, true);
                
                if (json_last_error() !== JSON_ERROR_NONE) {
                    log_message('error', 'JSON decode error: ' . json_last_error_msg());
                    return null;
                }
                
                if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                    $botReply = $result['candidates'][0]['content']['parts'][0]['text'];
                    log_message('info', 'Google AI response successful: ' . substr($botReply, 0, 100) . '...');
                    return $botReply;
                } else {
                    log_message('error', 'Google AI response format unexpected: ' . json_encode($result));
                    return null;
                }
                         } else {
                 // Handle API errors
                 log_message('error', 'Google AI API failed with HTTP code: ' . $httpCode);
                 $errorData = json_decode($response, true);
                 if (isset($errorData['error']['message'])) {
                     log_message('error', 'Google AI API Error: ' . $errorData['error']['message']);
                     
                     // Check if it's a rate limit error
                     if (strpos($errorData['error']['message'], 'quota') !== false || strpos($errorData['error']['message'], 'rate') !== false || $httpCode === 429) {
                         log_message('warning', 'Google AI rate limit/quota exceeded, will use fallback');
                         return 'RATE_LIMIT_EXCEEDED';
                     }
                 } else {
                     log_message('error', 'Google AI API failed - HTTP: ' . $httpCode . ', Response: ' . substr($response, 0, 500));
                 }
                 return null;
             }
            
        } catch (\Exception $e) {
            log_message('error', 'Google AI request failed with exception: ' . $e->getMessage());
            log_message('error', 'Stack trace: ' . $e->getTraceAsString());
            return null;
        }
    }
    
    /**
     * Get Hugging Face AI response (original method)
     */
    private function getHuggingFaceResponseOriginal($message, $sessionId, $userId)
    {
        try {
            // Hugging Face Inference API (completely free)
            $apiUrl = 'https://api-inference.huggingface.co/models/facebook/blenderbot-400M-distill';
            
            $startTime = microtime(true);
            
            $data = [
                'inputs' => $message,
                'options' => [
                    'wait_for_model' => true
                ]
            ];
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'User-Agent: RMBStore-Chatbot/1.0'
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            $endTime = microtime(true);
            $responseTime = round(($endTime - $startTime) * 1000);
            
            if ($httpCode === 200 && $response) {
                $result = json_decode($response, true);
                
                if (isset($result[0]['generated_text'])) {
                    $aiResponse = $result[0]['generated_text'];
                    
                    // Log Hugging Face interaction
                    $this->logHuggingFaceInteraction($sessionId, $userId, $message, $aiResponse, $responseTime);
                    
                    return $aiResponse;
                } else {
                    log_message('error', 'Hugging Face response format unexpected: ' . json_encode($result));
                }
            } else {
                log_message('error', 'Hugging Face API failed - HTTP: ' . $httpCode . ', Response: ' . $response);
            }
            
            return null;
            
        } catch (\Exception $e) {
            log_message('error', 'Hugging Face API error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get alternative Hugging Face model response
     */
    private function getAlternativeHuggingFaceResponse($message, $sessionId, $userId, $responseTime)
    {
        try {
            // Alternative model: Microsoft DialoGPT
            $apiUrl = 'https://api-inference.huggingface.co/models/microsoft/DialoGPT-medium';
            
            $data = [
                'inputs' => $message,
                'options' => [
                    'wait_for_model' => true
                ]
            ];
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'User-Agent: RMBStore-Chatbot/1.0'
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            
            if ($httpCode === 200 && $response) {
                $result = json_decode($response, true);
                
                if (isset($result[0]['generated_text'])) {
                    $aiResponse = $result[0]['generated_text'];
                    
                    // Log Hugging Face interaction
                    $this->logHuggingFaceInteraction($sessionId, $userId, $message, $aiResponse, $responseTime);
                    
                    return $aiResponse;
                } else {
                    log_message('error', 'Alternative Hugging Face response format unexpected: ' . json_encode($result));
                }
            } else {
                log_message('error', 'Alternative Hugging Face API failed - HTTP: ' . $httpCode . ', Response: ' . $response);
            }
            
            return null;
            
        } catch (\Exception $e) {
            log_message('error', 'Alternative Hugging Face API error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Log Hugging Face interaction
     */
    private function logHuggingFaceInteraction($sessionId, $userId, $query, $response, $responseTime)
    {
        try {
            $db = \Config\Database::connect();
            
            $data = [
                'session_id' => $sessionId,
                'user_id' => $userId,
                'user_query' => $query,
                'cici_ai_response' => $response, // Reusing existing field
                'response_time_ms' => $responseTime,
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $db->table('cici_ai_logs')->insert($data);
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to log Hugging Face interaction: ' . $e->getMessage());
        }
    }
    
    /**
     * Get store context data for AI enhancement
     */
    private function getStoreContext()
    {
        try {
            $db = \Config\Database::connect();
            $context = [];
            
            // Get store information from FAQ table (with error handling)
            try {
                $faqResults = $db->table('chatbot_faq')
                    ->where('is_active', 1)
                    ->orderBy('priority', 'DESC')
                    ->limit(20)
                    ->get();
                
                if ($faqResults) {
                    $faqArray = $faqResults->getResultArray();
                    foreach ($faqArray as $faq) {
                        $context['faq'][$faq['category']][] = [
                            'question' => $faq['query'],
                            'answer' => $faq['response']
                        ];
                    }
                }
            } catch (\Exception $e) {
                log_message('info', 'FAQ data not available: ' . $e->getMessage());
                $context['faq'] = [];
            }
            
            // Use default product categories since the products table doesn't have a category column
            $context['categories'] = ['Electronics', 'Fashion', 'Accessories', 'Smartphones', 'Laptops', 'Shoes', 'Clothing'];
            
            // Get store basic info from settings table (with error handling)
            try {
                $storeSettings = $db->table('settings')
                    ->select('setting_key, setting_value')
                    ->whereIn('setting_key', ['store_name', 'store_type', 'store_description'])
                    ->get();
                
                if ($storeSettings) {
                    $storeArray = $storeSettings->getResultArray();
                } else {
                    $storeArray = [];
                }
            } catch (\Exception $e) {
                log_message('info', 'Store settings not available: ' . $e->getMessage());
                $storeArray = [];
            }
            
            $storeInfo = [
                'name' => 'RMB Store', // Default fallback
                'type' => 'Electronics and Fashion Retailer', // Default fallback
                'description' => 'Leading electronics and fashion retailer providing quality products and excellent customer service' // Default fallback
            ];
            
            // Update with actual settings from database
            foreach ($storeArray as $setting) {
                switch ($setting['setting_key']) {
                    case 'store_name':
                        $storeInfo['name'] = $setting['setting_value'] ?: $storeInfo['name'];
                        break;
                    case 'store_type':
                        $storeInfo['type'] = $setting['setting_value'] ?: $storeInfo['type'];
                        break;
                    case 'store_description':
                        $storeInfo['description'] = $setting['setting_value'] ?: $storeInfo['description'];
                        break;
                }
            }
            
            $context['store_info'] = $storeInfo;
            
            return $context;
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to get store context: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Build enhanced prompt with store context
     */
    private function buildEnhancedPrompt($message, $storeContext)
    {
        $prompt = "You are a helpful customer service chatbot for RMB Store, an electronics and fashion retailer. ";
        $prompt .= "Use the following store information to provide accurate, helpful responses:\n\n";
        
        // Add store info
        $prompt .= "**STORE INFORMATION:**\n";
        $prompt .= "- Store Name: " . $storeContext['store_info']['name'] . "\n";
        $prompt .= "- Type: " . $storeContext['store_info']['type'] . "\n";
        $prompt .= "- Description: " . $storeContext['store_info']['description'] . "\n\n";
        
        // Add product categories
        if (!empty($storeContext['categories'])) {
            $prompt .= "**PRODUCT CATEGORIES:**\n";
            $prompt .= "- " . implode(", ", $storeContext['categories']) . "\n\n";
        }
        
        // Add relevant FAQ data based on user message
        $relevantFAQs = $this->getRelevantFAQs($message, $storeContext['faq']);
        if (!empty($relevantFAQs)) {
            $prompt .= "**RELEVANT STORE INFORMATION:**\n";
            foreach ($relevantFAQs as $faq) {
                $prompt .= "- Q: " . $faq['question'] . "\n";
                $prompt .= "  A: " . $faq['answer'] . "\n";
            }
            $prompt .= "\n";
        }
        
        $prompt .= "**INSTRUCTIONS:**\n";
        $prompt .= "- Keep responses under 100 words\n";
        $prompt .= "- Be friendly and helpful\n";
        $prompt .= "- Use the store information above when relevant\n";
        $prompt .= "- If asked about products, mention we have them but direct to header search\n";
        $prompt .= "- For store-specific questions, use the FAQ data above\n\n";
        
        $prompt .= "**USER QUESTION:** " . $message;
        
        return $prompt;
    }
    
    /**
     * Get relevant FAQs based on user message
     */
    private function getRelevantFAQs($message, $faqs)
    {
        if (empty($faqs)) return [];
        
        $relevant = [];
        $messageLower = strtolower($message);
        
        // Check each FAQ category
        foreach ($faqs as $category => $categoryFAQs) {
            foreach ($categoryFAQs as $faq) {
                $questionLower = strtolower($faq['question']);
                $answerLower = strtolower($faq['answer']);
                
                // Simple keyword matching
                $keywords = explode(' ', $messageLower);
                foreach ($keywords as $keyword) {
                    if (strlen($keyword) > 2 && 
                        (strpos($questionLower, $keyword) !== false || 
                         strpos($answerLower, $keyword) !== false)) {
                        $relevant[] = $faq;
                        break 2; // Move to next category
                    }
                }
            }
        }
        
        // Limit to 3 most relevant FAQs
        return array_slice($relevant, 0, 3);
    }
    
    /**
     * Log Google AI interaction
     */
    private function logGoogleAIInteraction($sessionId, $userId, $query, $response, $responseTime)
    {
        try {
            $db = \Config\Database::connect();
            
            $data = [
                'session_id' => $sessionId,
                'user_id' => $userId,
                'user_query' => $query,
                'cici_ai_response' => $response, // Reusing existing field
                'response_time_ms' => $responseTime,
                'ai_provider' => 'google_ai',
                'created_at' => date('Y-m-d H:i:s')
            ];
            
            $db->table('cici_ai_logs')->insert($data);
            
        } catch (\Exception $e) {
            log_message('error', 'Failed to log Google AI interaction: ' . $e->getMessage());
        }
    }

    /**
     * Format AI response to be store-appropriate
     */
    private function formatAIResponse($aiResponse, $originalMessage)
    {
        // Clean up the AI response
        $response = trim($aiResponse);
        
        // Remove any inappropriate content and make it store-friendly
        $response = str_replace(['fuck', 'shit', 'damn', 'hell'], '', $response);
        
        // Add store context if the response seems generic
        if (strlen($response) < 50) {
            $response .= "\n\nI'm here to help you with anything about our store, products, or services!";
        }
        
        // Add emoji for friendliness
        if (strpos($response, '?') !== false) {
            $response = "🤔 " . $response;
        } elseif (strpos($response, '!') !== false) {
            $response = "💡 " . $response;
        } else {
            $response = "💬 " . $response;
        }
        
        return $response;
    }

    /**
     * Get AI response from multiple providers (Google AI first, then Hugging Face)
     */
    public function getAIResponse()
    {
        try {
            $input = $this->request->getJSON();
            
            if (!isset($input->message) || !isset($input->sessionId)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Message and session ID are required'
                ])->setStatusCode(400);
            }

            $message = $input->message;
            $sessionId = $input->sessionId;
            $userName = $input->userName ?? null;
            $userEmail = $input->userEmail ?? null;

            // Save or update user information
            $userId = $this->saveUserInfo($sessionId, $userName, $userEmail);
            
            // Save user message
            $this->saveMessage($sessionId, $userId, 'user', $message);

            // Try Google AI first (primary provider)
            log_message('info', 'Attempting Google AI response for: ' . $message);
            $aiResponse = $this->getGoogleAIResponse($message, $sessionId, $userId);
            
            if ($aiResponse && !empty(trim($aiResponse))) {
                // Format the AI response to be store-appropriate
                $formattedResponse = $this->formatAIResponse($aiResponse, $message);
                $this->saveMessage($sessionId, $userId, 'bot', $formattedResponse);
                
                return $this->response->setJSON([
                    'status' => 'success',
                    'response' => $formattedResponse,
                    'type' => 'ai_response',
                    'provider' => 'google_ai'
                ]);
            }
            
            // Fallback to Hugging Face if Google AI fails
            log_message('info', 'Google AI failed, trying Hugging Face for: ' . $message);
            $aiResponse = $this->getHuggingFaceResponse($message, $sessionId, $userId);
            
            if ($aiResponse && !empty(trim($aiResponse))) {
                // Format the AI response to be store-appropriate
                $formattedResponse = $this->formatAIResponse($aiResponse, $message);
                $this->saveMessage($sessionId, $userId, 'bot', $formattedResponse);
                
                return $this->response->setJSON([
                    'status' => 'success',
                    'response' => $formattedResponse,
                    'type' => 'ai_response',
                    'provider' => 'hugging_face'
                ]);
            }
            
            // If both AI providers fail, return a helpful message
            $fallbackResponse = "I'm having trouble connecting to my AI services right now. However, I can still help you with:\n\n• **Store Information** - Hours, location, contact\n• **Policies & Services** - Returns, warranties, delivery\n• **General Questions** - About our business\n\nTry asking me something specific like 'What are your store hours?' or 'What is your return policy?'";
            
            $this->saveMessage($sessionId, $userId, 'bot', $fallbackResponse);
            
            return $this->response->setJSON([
                'status' => 'success',
                'response' => $fallbackResponse,
                'type' => 'fallback_response',
                'provider' => 'none'
            ]);
            
        } catch (\Exception $e) {
            log_message('error', 'AI response generation failed: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'AI response generation failed: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    /**
     * Check if a query is unclear or ambiguous
     */
    private function isUnclearQuery($message)
    {
        $message = strtolower($message);
        
        // Single words or very short queries are often unclear
        if (str_word_count($message) <= 1) {
            return true;
        }
        
        // Check for ambiguous terms that could mean multiple things
        $ambiguousTerms = ['mac', 'nike', 'phone', 'laptop', 'shoes', 'watch', 'apple', 'samsung'];
        foreach ($ambiguousTerms as $term) {
            if (strpos($message, $term) !== false && str_word_count($message) <= 2) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Get query confirmation response when message is unclear
     */
    private function getQueryConfirmationResponse($message)
    {
        $message = strtolower($message);
        
        // Check for unclear or ambiguous queries
        $unclearPatterns = [
            'mac' => 'Are you looking for Mac computers/laptops, or something else?',
            'nike' => 'Are you looking for Nike shoes, clothing, or accessories?',
            'phone' => 'Are you looking for smartphones, phone accessories, or phone services?',
            'laptop' => 'Are you looking for laptop computers, laptop bags, or laptop accessories?',
            'shoes' => 'Are you looking for athletic shoes, casual shoes, or formal shoes?',
            'watch' => 'Are you looking for smartwatches, traditional watches, or watch accessories?'
        ];
        
        foreach ($unclearPatterns as $pattern => $confirmation) {
            if (strpos($message, $pattern) !== false) {
                return "🤔 {$confirmation}\n\nPlease be more specific so I can help you better!";
            }
        }
        
        // General unclear query response
        return "🤔 I'm not sure I understand your request clearly. Could you please:\n\n• **Be more specific** about what you're looking for\n• **Use complete sentences** (e.g., 'Do you have MacBook laptops?')\n• **Ask about store info** (e.g., 'What are your store hours?')\n\nI'm here to help once I understand better!";
    }

    /**
     * Get store inquiry fallback response
     */
    private function getStoreInquiryFallback($message)
    {
        $message = strtolower($message);
        
        // Store-specific fallbacks
        if (strpos($message, 'hours') !== false || strpos($message, 'time') !== false || strpos($message, 'open') !== false) {
            return "🕐 Our store hours are Monday to Friday 9:00 AM - 6:00 PM, Saturday 10:00 AM - 4:00 PM, and Sunday 11:00 AM - 3:00 PM. We're closed on major holidays.";
        }
        
        if (strpos($message, 'location') !== false || strpos($message, 'address') !== false || strpos($message, 'where') !== false) {
            return "📍 We're located at 123 Main Street, Downtown Area. You can find us near the Central Plaza, just a few blocks from the main bus station.";
        }
        
        if (strpos($message, 'contact') !== false || strpos($message, 'phone') !== false || strpos($message, 'email') !== false) {
            return "📞 You can reach us at:\n• Phone: (555) 123-4567\n• Email: info@rmbstore.com\n• WhatsApp: +1 (555) 123-4567\n\nWe typically respond within 2-4 hours during business days.";
        }
        
        if (strpos($message, 'return') !== false || strpos($message, 'refund') !== false || strpos($message, 'exchange') !== false) {
            return "🔄 Our return policy:\n• 30-day return window for most items\n• Must be in original condition with packaging\n• Electronics have 14-day return window\n• Refunds processed within 5-7 business days";
        }
        
        if (strpos($message, 'delivery') !== false || strpos($message, 'shipping') !== false || strpos($message, 'deliver') !== false) {
            return "🚚 Delivery options:\n• Standard shipping: 3-5 business days ($5.99)\n• Express shipping: 1-2 business days ($12.99)\n• Free shipping on orders over $50\n• Local pickup available at our store";
        }
        
        if (strpos($message, 'warranty') !== false || strpos($message, 'guarantee') !== false) {
            return "🛡️ Warranty information:\n• Electronics: 1-year manufacturer warranty\n• Extended warranty available for purchase\n• 90-day satisfaction guarantee on all items\n• Technical support included with electronics";
        }
        
        // Default store inquiry response
        return "🏪 I'm here to help with store information! You can ask me about:\n\n• **Store Hours & Location**\n• **Contact Information**\n• **Return & Refund Policies**\n• **Delivery & Shipping**\n• **Warranty & Support**\n\nWhat specific information do you need?";
    }

    /**
     * Get smart fallback response based on message type
     */
    private function getSmartFallbackResponse($message)
    {
        $message = strtolower($message);
        
        // Time/Date questions
        if (strpos($message, 'time') !== false || strpos($message, 'date') !== false || strpos($message, 'what time') !== false || strpos($message, 'what date') !== false) {
            $currentTime = date('H:i:s');
            $currentDate = date('l, F j, Y');
            return "🕐 The current server time is {$currentTime} and today is {$currentDate}. I'm here to help you with store information, products, and any other questions you might have about RMB Store!";
        }
        
        // Weather questions
        if (strpos($message, 'weather') !== false || strpos($message, 'temperature') !== false) {
            return "🌤️ I don't have access to real-time weather information, but I'd be happy to help you with store-related questions! You can ask me about our products, store hours, policies, or any other store information.";
        }
        
        // General greetings
        if (strpos($message, 'hello') !== false || strpos($message, 'hi') !== false || strpos($message, 'hey') !== false) {
            return "👋 Hello! Welcome to RMB Store! I'm here to help you with any questions about our products, store hours, policies, or services. What can I assist you with today?";
        }
        
        // Help questions
        if (strpos($message, 'help') !== false || strpos($message, 'support') !== false) {
            return "🆘 I'm here to help! I can assist you with:\n\n• **Product Information** - Search and details\n• **Store Hours & Location** - When and where to find us\n• **Policies** - Returns, warranties, delivery\n• **General Questions** - About our business\n\nWhat would you like to know?";
        }
        
        // Product availability questions
        if (strpos($message, 'do you have') !== false || strpos($message, 'do you sell') !== false || strpos($message, 'do you carry') !== false) {
            return "🛍️ I can help you search for products! Use the search bar at the top of the page to find specific items, or ask me about our product categories. I can also help with store policies and information.";
        }
        
        // Default helpful response
        return "💬 I'm here to help with store information and answer your questions! You can ask me about:\n\n• **Products** - Search and availability\n• **Store Information** - Hours, location, contact\n• **Policies** - Returns, warranties, delivery\n• **General Questions** - About our business\n\nWhat would you like to know?";
    }

    /**
     * Test Google AI integration
     */
    public function testGoogleAI()
    {
        try {
            $testMessage = "What are your store hours?";
            $sessionId = 'test_' . time();
            $userId = 1;
            
            log_message('info', 'Testing Google AI integration with store context...');
            
            // Test Google AI directly
            $aiResponse = $this->getGoogleAIResponse($testMessage, $sessionId, $userId);
            
            if ($aiResponse && !empty(trim($aiResponse))) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Google AI is working with store context!',
                    'test_message' => $testMessage,
                    'ai_response' => $aiResponse,
                    'provider' => 'google_ai'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Google AI test failed - no response received',
                    'test_message' => $testMessage
                ]);
            }
            
        } catch (\Exception $e) {
            log_message('error', 'Google AI test failed: ' . $e->getMessage());
            
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Google AI test failed: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }
}
