<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class AppController extends BaseController
{
    public function fileManager()
    {
        $data = [
            'title' => 'File Manager',
            'subTitle' => 'Welcome to Geex Modern Admin Dashboard',
        ];
        return view('app/fileManager', $data);
    }

    public function contact()
    {
        $data = [
            'title' => 'Contacts',
            'subTitle' => 'Welcome to Geex Modern Admin Dashboard',
        ];
        return view('app/contact', $data);
    }

    public function kanban()
    {
        $data = [
            'title' => 'Kanban',
            'subTitle' => 'Welcome to Geex Modern Admin Dashboard',
        ];
        return view('app/kanban', $data);
    }

    public function todo()
    {
        $data = [
            'title' => 'Todo',
            'subTitle' => 'Form Elements is used to style and format the input field',
        ];
        return view('app/todo', $data);
    }

    public function chat()
    {
        $data = [
            'title' => 'Chat',
            'subTitle' => 'Form Elements is used to style and format the input field',
        ];
        return view('app/chat', $data);
    }

    public function calender()
    {
        $data = [
            'title' => 'Calendar',
            'subTitle' => 'Form Elements is used to style and format the input field',
        ];
        return view('app/calender', $data);
    }
}
