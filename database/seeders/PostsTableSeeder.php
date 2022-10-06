<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::create([
            'title' => 'Top New Collection',
            'slug' => 'top-new-collection',
            'description' => '<p style="margin-bottom: 1.25rem; font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras non placerat mi. Etiam non tellus sem. Aenean pretium convallis lorem, sit amet dapibus ante mollis a. Integer bibendum interdum sem, eget volutpat purus pulvinar in. Sed tristique augue vitae sagittis porta. Phasellus ullamcorper, dolor suscipit mattis viverra, sapien elit condimentum odio, ut imperdiet nisi risus sit amet ante. Sed sem lorem, laoreet et facilisis quis, tincidunt non lorem. Etiam tempus, dolor in sollicitudin faucibus, sem massa accumsan erat.</p><h3 style="margin: 0px 0px 20px; font-family: Poppins, sans-serif; line-height: 27px; color: rgb(33, 41, 60); font-size: 18px;">“ Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model search for evolved over sometimes by accident, sometimes on purpose ”</h3><p style="margin-bottom: 1.25rem; font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px;">Aenean lorem diam, venenatis nec venenatis id, adipiscing ac massa. Nam vel dui eget justo dictum pretium a rhoncus ipsum. Donec venenatis erat tincidunt nunc suscipit, sit amet bibendum lacus posuere. Sed scelerisque, dolor a pharetra sodales, mi augue consequat sapien, et interdum tellus leo et nunc. Nunc imperdiet eu libero ut imperdiet.</p>',
            'author_id' => 1,
            'short_desc' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard..."
        ]);

        Post::create([
            'title' => 'Fashion Trends',
            'slug' => 'fashion-trends',
            'description' => '<p style="margin-bottom: 1.25rem; font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras non placerat mi. Etiam non tellus sem. Aenean pretium convallis lorem, sit amet dapibus ante mollis a. Integer bibendum interdum sem, eget volutpat purus pulvinar in. Sed tristique augue vitae sagittis porta. Phasellus ullamcorper, dolor suscipit mattis viverra, sapien elit condimentum odio, ut imperdiet nisi risus sit amet ante. Sed sem lorem, laoreet et facilisis quis, tincidunt non lorem. Etiam tempus, dolor in sollicitudin faucibus, sem massa accumsan erat.</p><h3 style="margin: 0px 0px 20px; font-family: Poppins, sans-serif; line-height: 27px; color: rgb(33, 41, 60); font-size: 18px;">“ Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model search for evolved over sometimes by accident, sometimes on purpose ”</h3><p style="margin-bottom: 1.25rem; font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px;">Aenean lorem diam, venenatis nec venenatis id, adipiscing ac massa. Nam vel dui eget justo dictum pretium a rhoncus ipsum. Donec venenatis erat tincidunt nunc suscipit, sit amet bibendum lacus posuere. Sed scelerisque, dolor a pharetra sodales, mi augue consequat sapien, et interdum tellus leo et nunc. Nunc imperdiet eu libero ut imperdiet.</p>',
            'author_id' => 1,
            'short_desc' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard..."
        ]);

        Post::create([
            'title' => 'Right Choices',
            'slug' => 'right-choices',
            'description' => '<p style="margin-bottom: 1.25rem; font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras non placerat mi. Etiam non tellus sem. Aenean pretium convallis lorem, sit amet dapibus ante mollis a. Integer bibendum interdum sem, eget volutpat purus pulvinar in. Sed tristique augue vitae sagittis porta. Phasellus ullamcorper, dolor suscipit mattis viverra, sapien elit condimentum odio, ut imperdiet nisi risus sit amet ante. Sed sem lorem, laoreet et facilisis quis, tincidunt non lorem. Etiam tempus, dolor in sollicitudin faucibus, sem massa accumsan erat.</p><h3 style="margin: 0px 0px 20px; font-family: Poppins, sans-serif; line-height: 27px; color: rgb(33, 41, 60); font-size: 18px;">“ Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model search for evolved over sometimes by accident, sometimes on purpose ”</h3><p style="margin-bottom: 1.25rem; font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px;">Aenean lorem diam, venenatis nec venenatis id, adipiscing ac massa. Nam vel dui eget justo dictum pretium a rhoncus ipsum. Donec venenatis erat tincidunt nunc suscipit, sit amet bibendum lacus posuere. Sed scelerisque, dolor a pharetra sodales, mi augue consequat sapien, et interdum tellus leo et nunc. Nunc imperdiet eu libero ut imperdiet.</p>',
            'author_id' => 1,
            'short_desc' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard..."
        ]);

        Post::create([
            'title' => 'Perfect Accessories',
            'slug' => 'perfect-accessories',
            'description' => '<p style="margin-bottom: 1.25rem; font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras non placerat mi. Etiam non tellus sem. Aenean pretium convallis lorem, sit amet dapibus ante mollis a. Integer bibendum interdum sem, eget volutpat purus pulvinar in. Sed tristique augue vitae sagittis porta. Phasellus ullamcorper, dolor suscipit mattis viverra, sapien elit condimentum odio, ut imperdiet nisi risus sit amet ante. Sed sem lorem, laoreet et facilisis quis, tincidunt non lorem. Etiam tempus, dolor in sollicitudin faucibus, sem massa accumsan erat.</p><h3 style="margin: 0px 0px 20px; font-family: Poppins, sans-serif; line-height: 27px; color: rgb(33, 41, 60); font-size: 18px;">“ Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model search for evolved over sometimes by accident, sometimes on purpose ”</h3><p style="margin-bottom: 1.25rem; font-family: &quot;Open Sans&quot;, sans-serif; font-size: 14px;">Aenean lorem diam, venenatis nec venenatis id, adipiscing ac massa. Nam vel dui eget justo dictum pretium a rhoncus ipsum. Donec venenatis erat tincidunt nunc suscipit, sit amet bibendum lacus posuere. Sed scelerisque, dolor a pharetra sodales, mi augue consequat sapien, et interdum tellus leo et nunc. Nunc imperdiet eu libero ut imperdiet.</p>',
            'author_id' => 1,
            'short_desc' => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard..."
        ]);
    }
}
