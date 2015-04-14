<?php

namespace App\Http\Controllers;

use view;

class BOMController extends Controller
{
    public function listBOM() {
        return view('BOM.listBOM', ['page_title' => 'BOM']);
    }
    public function addBOM() {
           return view('BOM.addBOM', ['page_title' => 'Add BOM']);
    }
    public function editBOM() {
            exit("edit");
    }
    public function deleteBOM() {
            exit("delete");
    }
    public function getBOMData() {
            exit("getData");
    }
    
    
}
