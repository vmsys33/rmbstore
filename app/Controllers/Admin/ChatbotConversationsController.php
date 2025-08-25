<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class ChatbotConversationsController
 * Admin controller for managing chatbot conversations
 */
class ChatbotConversationsController extends BaseController
{
    protected $request;
    protected $helpers = ['form', 'url'];

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->request = $request;
    }

    /**
     * Display the main conversations dashboard
     */
    public function index()
    {
        // Check if database tables exist
        try {
            $db = \Config\Database::connect();
            
            // Check if tables exist
            $tables = ['chatbot_users', 'chatbot_sessions', 'chatbot_messages', 'user_product_inquiries', 'cici_ai_logs'];
            $missingTables = [];
            
            foreach ($tables as $table) {
                if (!$db->tableExists($table)) {
                    $missingTables[] = $table;
                }
            }
            
            if (!empty($missingTables)) {
                // Show setup message if tables are missing
                return view('admin/chatbot_conversations/setup_required', [
                    'missingTables' => $missingTables
                ]);
            }
            
        } catch (\Exception $e) {
            // Show error if database connection fails
            return view('admin/chatbot_conversations/error', [
                'error' => 'Database connection failed: ' . $e->getMessage()
            ]);
        }
        
        return view('admin/chatbot_conversations/index');
    }

    /**
     * Get conversations data for DataTable
     */
    public function getConversations()
    {
        try {
            $db = \Config\Database::connect();
            
            // Get parameters for pagination and filtering
            $start = $this->request->getGet('start') ?? 0;
            $length = $this->request->getGet('length') ?? 10;
            $search = $this->request->getGet('search[value]') ?? '';
            $orderColumn = $this->request->getGet('order[0][column]') ?? 0;
            $orderDir = $this->request->getGet('order[0][dir]') ?? 'desc';
            
            // Column mapping
            $columns = ['id', 'user_name', 'user_email', 'total_messages', 'status', 'first_message_at', 'last_message_at'];
            $orderBy = $columns[$orderColumn] ?? 'id';
            
            // Build query
            $builder = $db->table('chatbot_sessions cs')
                         ->select('cs.*, cu.user_name, cu.user_email, cu.ip_address')
                         ->join('chatbot_users cu', 'cs.user_id = cu.id', 'left')
                         ->orderBy($orderBy, $orderDir);
            
            // Apply search filter
            if (!empty($search)) {
                $builder->groupStart()
                        ->like('cu.user_name', $search)
                        ->orLike('cu.user_email', $search)
                        ->orLike('cs.session_id', $search)
                        ->orLike('cu.ip_address', $search)
                        ->groupEnd();
            }
            
            // Get total count
            $totalRecords = $builder->countAllResults(false);
            
            // Apply pagination
            $builder->limit($length, $start);
            
            // Get results
            $conversations = $builder->get()->getResultArray();
            
            // Format data for DataTable
            $data = [];
            foreach ($conversations as $conv) {
                $data[] = [
                    'id' => $conv['id'],
                    'session_id' => $conv['session_id'],
                    'user_name' => $conv['user_name'] ?: 'Anonymous',
                    'user_email' => $conv['user_email'] ?: 'N/A',
                    'ip_address' => $conv['ip_address'],
                    'total_messages' => $conv['total_messages'],
                    'status' => $this->getStatusBadge($conv['status']),
                    'first_message_at' => date('M j, Y g:i A', strtotime($conv['first_message_at'])),
                    'last_message_at' => date('M j, Y g:i A', strtotime($conv['last_message_at'])),
                    'actions' => $this->getActionButtons($conv['id'], $conv['session_id'])
                ];
            }
            
            return $this->response->setJSON([
                'draw' => intval($this->request->getGet('draw')),
                'recordsTotal' => $totalRecords,
                'recordsFiltered' => $totalRecords,
                'data' => $data
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => 'Failed to fetch conversations: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    /**
     * Get conversation details
     */
    public function getConversationDetails($sessionId)
    {
        try {
            $db = \Config\Database::connect();
            
            // Get conversation info
            $conversation = $db->table('chatbot_sessions cs')
                              ->select('cs.*, cu.user_name, cu.user_email, cu.ip_address, cu.user_agent, cu.created_at as user_created')
                              ->join('chatbot_users cu', 'cs.user_id = cu.id', 'left')
                              ->where('cs.session_id', $sessionId)
                              ->get()
                              ->getRowArray();
            
            if (!$conversation) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Conversation not found'
                ])->setStatusCode(404);
            }
            
            // Get messages
            $messages = $db->table('chatbot_messages')
                          ->select('*')
                          ->where('session_id', $sessionId)
                          ->orderBy('created_at', 'ASC')
                          ->get()
                          ->getResultArray();
            
            // Get product inquiries
            $inquiries = $db->table('user_product_inquiries')
                           ->select('*')
                           ->where('session_id', $sessionId)
                           ->orderBy('created_at', 'ASC')
                           ->get()
                           ->getResultArray();
            
            // Get CICI AI logs
            $ciciLogs = $db->table('cici_ai_logs')
                           ->select('*')
                           ->where('session_id', $sessionId)
                           ->orderBy('created_at', 'ASC')
                           ->get()
                           ->getResultArray();
            
            return $this->response->setJSON([
                'status' => 'success',
                'conversation' => $conversation,
                'messages' => $messages,
                'inquiries' => $inquiries,
                'cici_logs' => $ciciLogs
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to get conversation details: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    /**
     * Update conversation status
     */
    public function updateStatus()
    {
        try {
            $input = $this->request->getJSON();
            
            if (!isset($input->sessionId) || !isset($input->status)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Session ID and status are required'
                ])->setStatusCode(400);
            }
            
            $db = \Config\Database::connect();
            
            $result = $db->table('chatbot_sessions')
                        ->where('session_id', $input->sessionId)
                        ->update([
                            'status' => $input->status,
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
            
            if ($result) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Status updated successfully'
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to update status'
                ])->setStatusCode(500);
            }
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to update status: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    /**
     * Delete conversation
     */
    public function deleteConversation()
    {
        try {
            $input = $this->request->getJSON();
            
            if (!isset($input->sessionId)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Session ID is required'
                ])->setStatusCode(400);
            }
            
            $db = \Config\Database::connect();
            
            // Start transaction
            $db->transStart();
            
            // Delete related records
            $db->table('chatbot_messages')->where('session_id', $input->sessionId)->delete();
            $db->table('user_product_inquiries')->where('session_id', $input->sessionId)->delete();
            $db->table('cici_ai_logs')->where('session_id', $input->sessionId)->delete();
            $db->table('chatbot_sessions')->where('session_id', $input->sessionId)->delete();
            
            // Commit transaction
            $db->transComplete();
            
            if ($db->transStatus() === false) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Failed to delete conversation'
                ])->setStatusCode(500);
            }
            
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Conversation deleted successfully'
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to delete conversation: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    /**
     * Export conversations to CSV
     */
    public function exportConversations()
    {
        try {
            $db = \Config\Database::connect();
            
            $conversations = $db->table('chatbot_sessions cs')
                               ->select('cs.*, cu.user_name, cu.user_email, cu.ip_address')
                               ->join('chatbot_users cu', 'cs.user_id = cu.id', 'left')
                               ->orderBy('cs.created_at', 'DESC')
                               ->get()
                               ->getResultArray();
            
            // Set headers for CSV download
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="chatbot_conversations_' . date('Y-m-d_H-i-s') . '.csv"');
            
            $output = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($output, [
                'ID', 'Session ID', 'User Name', 'User Email', 'IP Address',
                'Status', 'Total Messages', 'First Message', 'Last Message'
            ]);
            
            // CSV data
            foreach ($conversations as $conv) {
                fputcsv($output, [
                    $conv['id'],
                    $conv['session_id'],
                    $conv['user_name'] ?: 'Anonymous',
                    $conv['user_email'] ?: 'N/A',
                    $conv['ip_address'],
                    $conv['status'],
                    $conv['total_messages'],
                    $conv['first_message_at'],
                    $conv['last_message_at']
                ]);
            }
            
            fclose($output);
            exit;
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to export conversations: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    /**
     * Get conversation statistics
     */
    public function getStatistics()
    {
        try {
            $db = \Config\Database::connect();
            
            // Total conversations
            $totalConversations = $db->table('chatbot_sessions')->countAllResults();
            
            // Active conversations
            $activeConversations = $db->table('chatbot_sessions')
                                    ->where('status', 'active')
                                    ->countAllResults();
            
            // Total messages
            $totalMessages = $db->table('chatbot_messages')->countAllResults();
            
            // Total users
            $totalUsers = $db->table('chatbot_users')->countAllResults();
            
            // AI usage (Hugging Face)
            $aiUsage = $db->table('chatbot_messages')
                          ->where('cici_ai_used', true)
                          ->countAllResults();
            
            // Product inquiries
            $productInquiries = $db->table('user_product_inquiries')->countAllResults();
            
            // Recent activity (last 7 days)
            $recentActivity = $db->table('chatbot_sessions')
                                ->where('created_at >=', date('Y-m-d H:i:s', strtotime('-7 days')))
                                ->countAllResults();
            
            return $this->response->setJSON([
                'status' => 'success',
                'data' => [
                    'total_conversations' => $totalConversations,
                    'active_conversations' => $activeConversations,
                    'total_messages' => $totalMessages,
                    'total_users' => $totalUsers,
                    'ai_usage' => $aiUsage,
                    'product_inquiries' => $productInquiries,
                    'recent_activity' => $recentActivity
                ]
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to get statistics: ' . $e->getMessage()
            ])->setStatusCode(500);
        }
    }

    /**
     * Get status badge HTML
     */
    private function getStatusBadge($status)
    {
        $badges = [
            'active' => '<span class="badge badge-success">Active</span>',
            'completed' => '<span class="badge badge-info">Completed</span>',
            'abandoned' => '<span class="badge badge-warning">Abandoned</span>'
        ];
        
        return $badges[$status] ?? '<span class="badge badge-secondary">Unknown</span>';
    }

    /**
     * Get action buttons HTML
     */
    private function getActionButtons($id, $sessionId)
    {
        return '
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-sm btn-info" onclick="viewConversation(\'' . $sessionId . '\')" title="View Details">
                    <i class="fas fa-eye"></i>
                </button>
                <button type="button" class="btn btn-sm btn-warning" onclick="editConversation(' . $id . ')" title="Edit">
                    <i class="fas fa-edit"></i>
                </button>
                <button type="button" class="btn btn-sm btn-danger" onclick="deleteConversation(\'' . $sessionId . '\')" title="Delete">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        ';
    }
}
