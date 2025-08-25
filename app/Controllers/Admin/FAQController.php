<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class FAQController
 * Handles FAQ management for the chatbot system
 */
class FAQController extends BaseController
{
    protected $request;
    protected $helpers = ['form'];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->request = $request;
    }

    /**
     * Display FAQ management page
     */
    public function index()
    {
        try {
            $db = \Config\Database::connect();
            
            // Check if chatbot_faq table exists
            if (!$db->tableExists('chatbot_faq')) {
                return view('admin/faq/setup_required', [
                    'message' => 'The FAQ table does not exist. Please run the setup script first.'
                ]);
            }
            
            // Get all FAQ entries with pagination
            $page = $this->request->getGet('page') ?? 1;
            $limit = 20;
            $offset = ($page - 1) * $limit;
            
            // Get total count first
            $total = $db->table('chatbot_faq')->countAllResults();
            
            // Get FAQ entries with error handling
            $faqsQuery = $db->table('chatbot_faq')
                           ->select('*')
                           ->orderBy('priority', 'DESC')
                           ->orderBy('category', 'ASC')
                           ->orderBy('query', 'ASC')
                           ->limit($limit, $offset);
            
            $faqs = $faqsQuery->get();
            
            if ($faqs === false) {
                log_message('error', 'FAQ query failed: ' . $db->getLastQuery());
                throw new \Exception('Failed to fetch FAQ entries. Check database connection and table structure.');
            }
            
            $faqs = $faqs->getResultArray();
            
            // Get categories for filter with error handling
            $categoriesQuery = $db->table('chatbot_faq')
                                ->distinct()
                                ->select('category')
                                ->orderBy('category', 'ASC');
            
            $categoriesResult = $categoriesQuery->get();
            
            if ($categoriesResult === false) {
                log_message('error', 'Categories query failed: ' . $db->getLastQuery());
                throw new \Exception('Failed to fetch categories. Check database connection and table structure.');
            }
            
            $categories = $categoriesResult->getResultArray();
            
            $data = [
                'title' => 'FAQ Management',
                'subTitle' => 'Manage chatbot FAQ entries',
                'faqs' => $faqs,
                'categories' => $categories,
                'total' => $total,
                'page' => $page,
                'limit' => $limit,
                'totalPages' => ceil($total / $limit),
                'pagination' => [
                    'total_records' => $total,
                    'current_page' => $page,
                    'total_pages' => ceil($total / $limit),
                    'per_page' => $limit
                ]
            ];
            
            return view('admin/faq/index', $data);
            
        } catch (\Exception $e) {
            log_message('error', 'FAQ Controller Error: ' . $e->getMessage());
            log_message('error', 'Stack trace: ' . $e->getTraceAsString());
            
            return view('admin/faq/error', [
                'error' => 'Database error: ' . $e->getMessage() . "\n\nPlease check:\n1. Database connection\n2. Table structure\n3. Run test_faq_table.php to diagnose issues"
            ]);
        }
    }

    /**
     * Show FAQ creation form
     */
    public function create()
    {
        $data = [
            'title' => 'Create New FAQ',
            'subTitle' => 'Add a new FAQ entry for the chatbot',
            'faq' => null,
            'categories' => [
                'store_info' => 'Store Information',
                'products' => 'Products',
                'policies' => 'Policies',
                'services' => 'Services',
                'general' => 'General'
            ]
        ];
        
        return view('admin/faq/form', $data);
    }

    /**
     * Store new FAQ
     */
    public function store()
    {
        try {
            $rules = [
                'query' => 'required|min_length[3]|max_length[255]',
                'response' => 'required|min_length[10]',
                'category' => 'required|in_list[store_info,products,policies,services,general]',
                'priority' => 'required|integer|greater_than[0]|less_than_equal_to[10]'
            ];
            
            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
            
            $data = [
                'query' => $this->request->getPost('query'),
                'response' => $this->request->getPost('response'),
                'category' => $this->request->getPost('category'),
                'priority' => $this->request->getPost('priority'),
                'is_active' => $this->request->getPost('is_active') ? 1 : 0
            ];
            
            $db = \Config\Database::connect();
            $db->table('chatbot_faq')->insert($data);
            
            return redirect()->to('/admin/faq')->with('success', 'FAQ created successfully!');
            
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to create FAQ: ' . $e->getMessage());
        }
    }

    /**
     * Show FAQ edit form
     */
    public function edit($id = null)
    {
        try {
            if (!$id) {
                return redirect()->to('/admin/faq')->with('error', 'FAQ ID is required');
            }
            
            $db = \Config\Database::connect();
            $faq = $db->table('chatbot_faq')
                      ->where('id', $id)
                      ->get()
                      ->getRowArray();
            
            if (!$faq) {
                return redirect()->to('/admin/faq')->with('error', 'FAQ not found');
            }
            
            $data = [
                'title' => 'Edit FAQ',
                'subTitle' => 'Modify FAQ entry for the chatbot',
                'faq' => $faq,
                'categories' => [
                    'store_info' => 'Store Information',
                    'products' => 'Products',
                    'policies' => 'Policies',
                    'services' => 'Services',
                    'general' => 'General'
                ]
            ];
            
            return view('admin/faq/form', $data);
            
        } catch (\Exception $e) {
            return redirect()->to('/admin/faq')->with('error', 'Failed to load FAQ: ' . $e->getMessage());
        }
    }

    /**
     * Update FAQ
     */
    public function update($id = null)
    {
        try {
            if (!$id) {
                return redirect()->to('/admin/faq')->with('error', 'FAQ ID is required');
            }
            
            $rules = [
                'query' => 'required|min_length[3]|max_length[255]',
                'response' => 'required|min_length[10]',
                'category' => 'required|in_list[store_info,products,policies,services,general]',
                'priority' => 'required|integer|greater_than[0]|less_than_equal_to[10]'
            ];
            
            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }
            
            $data = [
                'query' => $this->request->getPost('query'),
                'response' => $this->request->getPost('response'),
                'category' => $this->request->getPost('category'),
                'priority' => $this->request->getPost('priority'),
                'is_active' => $this->request->getPost('is_active') ? 1 : 0
            ];
            
            $db = \Config\Database::connect();
            $db->table('chatbot_faq')
               ->where('id', $id)
               ->update($data);
            
            return redirect()->to('/admin/faq')->with('success', 'FAQ updated successfully!');
            
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->with('error', 'Failed to update FAQ: ' . $e->getMessage());
        }
    }

    /**
     * Delete FAQ
     */
    public function delete($id = null)
    {
        try {
            if (!$id) {
                return redirect()->to('/admin/faq')->with('error', 'FAQ ID is required');
            }
            
            $db = \Config\Database::connect();
            $db->table('chatbot_faq')
               ->where('id', $id)
               ->delete();
            
            return redirect()->to('/admin/faq')->with('success', 'FAQ deleted successfully!');
            
        } catch (\Exception $e) {
            return redirect()->to('/admin/faq')->with('error', 'Failed to delete FAQ: ' . $e->getMessage());
        }
    }

    /**
     * Toggle FAQ active status
     */
    public function toggleStatus($id = null)
    {
        try {
            if (!$id) {
                return $this->response->setJSON(['success' => false, 'message' => 'FAQ ID is required']);
            }
            
            $db = \Config\Database::connect();
            
            // Get current status
            $faq = $db->table('chatbot_faq')
                      ->where('id', $id)
                      ->get()
                      ->getRowArray();
            
            if (!$faq) {
                return $this->response->setJSON(['success' => false, 'message' => 'FAQ not found']);
            }
            
            // Toggle status
            $newStatus = $faq['is_active'] ? 0 : 1;
            $db->table('chatbot_faq')
               ->where('id', $id)
               ->update(['is_active' => $newStatus]);
            
            return $this->response->setJSON([
                'success' => true, 
                'message' => 'FAQ status updated successfully!',
                'new_status' => $newStatus
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON(['success' => false, 'message' => 'Failed to update status: ' . $e->getMessage()]);
        }
    }

    /**
     * Search FAQ entries
     */
    public function search()
    {
        try {
            $query = $this->request->getGet('q');
            $category = $this->request->getGet('category');
            
            $db = \Config\Database::connect();
            $builder = $db->table('chatbot_faq');
            
            if ($query) {
                $builder->like('query', '%' . $query . '%')
                        ->orLike('response', '%' . $query . '%');
            }
            
            if ($category && $category !== 'all') {
                $builder->where('category', $category);
            }
            
            $faqs = $builder->select('*')
                           ->orderBy('priority', 'DESC')
                           ->orderBy('category', 'ASC')
                           ->orderBy('query', 'ASC')
                           ->get()
                           ->getResultArray();
            
            return $this->response->setJSON([
                'success' => true,
                'data' => $faqs
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Search failed: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get FAQ statistics
     */
    public function stats()
    {
        try {
            $db = \Config\Database::connect();
            
            // Total FAQs
            $total = $db->table('chatbot_faq')->countAllResults();
            
            // Active FAQs
            $active = $db->table('chatbot_faq')->where('is_active', 1)->countAllResults();
            
            // FAQs by category
            $byCategory = $db->table('chatbot_faq')
                            ->select('category, COUNT(*) as count')
                            ->groupBy('category')
                            ->get()
                            ->getResultArray();
            
            // Priority distribution
            $byPriority = $db->table('chatbot_faq')
                            ->select('priority, COUNT(*) as count')
                            ->groupBy('priority')
                            ->orderBy('priority', 'DESC')
                            ->get()
                            ->getResultArray();
            
            return $this->response->setJSON([
                'success' => true,
                'data' => [
                    'total' => $total,
                    'active' => $active,
                    'inactive' => $total - $active,
                    'by_category' => $byCategory,
                    'by_priority' => $byPriority
                ]
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to get statistics: ' . $e->getMessage()
            ]);
        }
    }
}
