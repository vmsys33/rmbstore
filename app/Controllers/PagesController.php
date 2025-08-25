<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class PagesController extends BaseController
{
    
    public function blog()
    {
        $data = [
            'title' => 'Blog',
            'subTitle' => 'Form Elements is used to style and format the input field',
        ];
        return  view('pages/blog', $data);
    }
    
    public function blogDetails()
    {
        $data = [
            'title' => 'Dashboard',
            'subTitle' => 'Form Elements is used to style and format the input field',
        ];
        return  view('pages/blogDetails', $data);
    }
    
    public function faq()
    {
        $data = [
            'title' => 'Faq',
            'subTitle' => 'Form Elements is used to style and format the input field',
        ];
        return  view('pages/faq', $data);
    }
    
    public function pricing()
    {
        $data = [
            'title' => 'Pricing',
            'subTitle' => 'Form Elements is used to style and format the input field',
        ];
        return  view('pages/pricing', $data);
    }
    
    public function testimonial()
    {
        $data = [
            'title' => 'Testimonial',
            'subTitle' => 'Form Elements is used to style and format the input field',
        ];
        return  view('pages/testimonial', $data);
    }
    
    public function terms()
    {
        $data = [
            'title' => 'Terms & Conditions',
            'subTitle' => 'Form Elements is used to style and format the input field',
        ];
        return  view('pages/terms', $data);
    }
    
    public function signin()
    {
        return  view('pages/signin');
    }
    
    public function signup()
    {
        return  view('pages/signup');
    }
    
    public function forgetPassword()
    {
        // Get settings data for favicon
        $settingsModel = new \App\Models\SettingsModel();
        $settings = $settingsModel->first();
        
        return view('pages/forgetPassword', ['settings' => $settings]);
    }
    
    public function verification()
    {
        // Get settings data for favicon
        $settingsModel = new \App\Models\SettingsModel();
        $settings = $settingsModel->first();
        
        return view('pages/verification', ['settings' => $settings]);
    }
    
    public function error()
    {
        return  view('pages/error');
    }
    
    public function comingsoon()
    {
        return  view('pages/comingsoon');
    }
    
    public function maintenance()
    {
        return  view('pages/maintenance');
    }
    
    public function blankpage()
    {
        $data = [
            'title' => 'Dashboard',
            'subTitle' => 'Form Elements is used to style and format the input field',
        ];
        return  view('pages/blankpage', $data);
    }
    
}
