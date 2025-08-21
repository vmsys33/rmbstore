<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminAuthFilter implements FilterInterface
{
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null       $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if admin is logged in
        if (!session()->get('admin_logged_in')) {
            // Check for remember token
            $rememberToken = $request->getCookie('admin_remember');
            if ($rememberToken) {
                $adminModel = new \App\Models\AdminModel();
                $admin = $adminModel->getByRememberToken($rememberToken);
                
                if ($admin && $admin['status'] === 'active') {
                    // Set session data
                    $sessionData = [
                        'admin_id' => $admin['id'],
                        'admin_name' => $admin['name'],
                        'admin_email' => $admin['email'],
                        'admin_role' => $admin['role'],
                        'admin_logged_in' => true
                    ];
                    session()->set($sessionData);
                    
                    // Update last login
                    $adminModel->updateLastLogin($admin['id']);
                    
                    return;
                }
            }
            
            // Redirect to login page
            return redirect()->to('/admin/login')->with('error', 'Please login to access the admin panel.');
        }
        
        // Update last activity
        session()->set('admin_last_activity', time());
    }

    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an exception or handling the response object
     * directly.
     *
     * @param RequestInterface  $request
     * @param ResponseInterface $response
     * @param array|null        $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
