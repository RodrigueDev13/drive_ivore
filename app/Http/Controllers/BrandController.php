<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Afficher toutes les marques.
     */
    public function index()
    {
        $brands = Brand::withCount('vehicles')->orderBy('name')->get();
        return view('brands.index', compact('brands'));
    }
}
