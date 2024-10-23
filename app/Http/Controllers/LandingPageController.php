<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    // public function hello(){
    //     return 'Hello World';
    // }

    // prak 3 nomor 8,9)
    // public function greeting(){
    //     return view('blog.hello', ['name' => 'Caca']);
    //     }
    // prak 3 nomor11
    // Public function greeting(){
    //     return view('blog.hello')
    //     ->with('name','Andi')
    //     ->with('occupation','Astronaut');
    // }

    //js 5 prak 2 (1)
    // public function index()
    // {
    //     $breadcrumb = (object)[
    //         'title' => 'Selamat Datang',
    //         'list' => ['Home', 'Welcome']
    //     ];
    //     $activeMenu = 'dasboard';
    //     return view('landingpage2', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu]);
    // }

    public function index()
{
    $cartItems = [
        (object) ['image' => 'cart-1.jpg', 'name' => 'bakery item 1', 'price' => 45.99],
        (object) ['image' => 'cart-2.jpg', 'name' => 'bakery item 2', 'price' => 15.99],
        (object) ['image' => 'cart-3.jpg', 'name' => 'bakery item 3', 'price' => 29.99],
    ];

    $slides = [
        (object) ['image' => 'slider1.jpg', 'caption' => 'we bake the world a better place'],
        (object) ['image' => 'slider2.jpg', 'caption' => 'we bake the world a better place'],
    ];

    $products = [
        (object) ['image' => 'product-1.jpg', 'name' => 'apple pie', 'price' => 15.99, 'rating' => 5],
        // Add more products as needed
    ];

    $galleryImages = ['gallery1.jpg', 'gallery2.jpg', 'gallery3.jpg']; // Add more images
    $promotions = [
        (object) ['image' => 'promotion1.png', 'name' => 'chocolat cake', 'description' => 'Lorem ipsum...'],
        // Add more promotions
    ];

    $teamMembers = [
        (object) ['image' => 'team2.png', 'name' => 'Chef 1', 'position' => 'Chef'],
        (object) ['image' => 'team1.png', 'name' => 'Chef 2', 'position' => 'Chef'],
        (object) ['image' => 'team3.png', 'name' => 'Chef 3', 'position' => 'Chef'],
        (object) ['image' => 'team1.png', 'name' => 'Chef 4', 'position' => 'Chef'],
        // Add more team members
    ];

    return view('landingpage', compact('cartItems', 'slides', 'products', 'galleryImages', 'promotions', 'teamMembers'));
}

}
?>