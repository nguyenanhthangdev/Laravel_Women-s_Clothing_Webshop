<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Post;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // --- ADMIN: START POST --- 

    public function post()
    {
        $posts = Post::all();
        return view('admin.post.post', compact('posts'));
    }

    public function addPost()
    {
        return view('admin.post.add-post');
    }

    public function savePost(Request $request)
    {
        try {
            // Tạo một bản ghi mới trong cơ sở dữ liệu
            $post = new Post();
            $post->title = $request->title;
            $post->detail = $request->detail;
            $post->status = $request->status === 'true' ? true : false;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('backend/images/post'), $imageName);
                $post->image = $imageName;
            }

            $post->save();

            return redirect()->intended('/admin/post')->with('success', 'Thêm mới bài viết thành công!');
        } catch (Exception $e) {
            // Xử lý ngoại lệ
            return back()->with('error', 'Đã xảy ra lỗi khi thêm mới bài viết.');
        }
    }

    public function editPost($post_id)
    {
        try {
            $post = Post::findOrFail($post_id);
            return view('admin.post.edit-post', compact('post'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.post')->with('error', 'Bài viết này không tồn tại!');
        }
    }

    public function updatePost(Request $request)
    {
        try {
            // Find the user by ID
            $post = Post::findOrFail($request->post_id);
            $imageName = '';
            // Handle image upload if present
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($post->image) {
                    $oldImagePath = public_path('/backend/images/post') . '/' . $post->image;
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('backend/images/post'), $imageName);
            }

            $post->fill([
                'title' => $request->title,
                'detail' => $request->detail,
                'status' => $request->status === 'true' ? true : false,
                'image' => $imageName !== '' ? $imageName : $post->image,
            ]);

            $post->save();

            // Redirect back with success message
            return redirect()->route('admin.post')->with('success', 'Chỉnh sửa thông tin bài viết thành công.');
        } catch (ModelNotFoundException $e) {
            // Handle case where user_id does not exist
            return redirect()->route('admin.post')->with('error', 'Bài viết này không tồn tại!');
        } catch (\Exception $e) {
            // Handle other exceptions
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra khi thay đổi thông tin bài viết.');
        }
    }

    public function deletePost($post_id)
    {
        try {
            $post = Post::findOrFail($post_id);

            // Xóa hình ảnh nếu tồn tại
            if ($post->image) {
                $imagePath = public_path('backend/images/post') . '/' . $post->image;
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $post->delete();

            return redirect()->back()->with('success', 'Đã xóa bài viết thành công.');
        } catch (ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Bài viết này không tồn tại.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã có lỗi xảy ra khi xóa bài viết.');
        }
    }

    // --- ADMIN: END POST ---

    // --- CLIENT: START POST ---

    public function postDetails($post_id)
    {
        try {
            $categories = Category::active()->get();
            $manufacturers = Manufacturer::active()->get();
            $post = Post::findOrFail($post_id);
            
            return view('client.home.post-details', compact('categories', 'manufacturers', 'post'));
        } catch (ModelNotFoundException $e) {
            return redirect()->route('client.home.home')->with('error', 'Bài viết này không tồn tại!');
        }
    }

    // --- CLIENT: END POST ---
}
