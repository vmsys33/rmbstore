<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class FeaturesController extends BaseController
{
    public function chart()
    {
        $data = [
            'title' => 'Chart',
            'subTitle' => 'Form Elements is used to style and format the input field',
        ];
        return view('features/chart', $data);
    }
    
    public function table()
    {
        $data = [
            'title' => 'Table',
            'subTitle' => 'Table Elements is used to style and format the input field',
        ];
        return view('features/table', $data);
    }
    
    public function badge()
    {
        $data = [
            'title' => 'Badge/Label',
            'subTitle' => 'Form Elements is used to style and format the input field',
        ];
        return view('features/badge',   $data);
    }
    
    public function button()
    {
        $data = [
            'title' => 'Button',
            'subTitle' => 'Form Elements is used to style and format the input field',
        ];
        return view('features/button', $data);
    }
    
    public function color()
    {
        $data = [
            'title' => 'Color',
            'subTitle' => 'Form Elements is used to style and format the input field',
        ];
        return view('features/color', $data);
    }
    
    public function form()
    {
        $data = [
            'title' => 'Form',
            'subTitle' => 'Form Elements is used to style and format the input field',
        ];
        return view('features/form', $data);
    }
    
    public function icon()
    {
        $data = [
            'title' => 'Icons',
            'subTitle' => 'Form Elements is used to style and format the input field',
        ];
        return view('features/icon', $data);
    }
    
    public function navigation()
    {
        $data = [
            'title' => 'Navigation',
            'subTitle' => 'Form Elements is used to style and format the input field',
        ];
        return view('features/navigation', $data);
    }
    
    public function typography()
    {
        $data = [
            'title' => 'Typography',
            'subTitle' => 'Form Elements is used to style and format the input field',
        ];
        return view('features/typography', $data);
    }
    
}
