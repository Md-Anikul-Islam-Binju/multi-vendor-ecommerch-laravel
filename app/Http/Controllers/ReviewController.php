<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\OrderDetail;
use App\Models\Review;
use App\Models\ReviewComment;
use App\Models\ReviewImageVideo;
use App\Traits\CreateSlug;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class ReviewController extends Controller
{
    use CreateSlug;
    //get customer review form
    public function getReviewForm(Request $request){
        $user_id = Auth::id();
        $data['order_id'] = ($request->order_id) ? $request->order_id : null;
        $data['product_id'] = $request->product_id;
        $data['review'] = Review::where('user_id', $user_id)->where('order_id', $request->order_id)->where('product_id', $request->product_id)->first();

        return view('users.review.review')->with($data);
    }

    //insert customer product review
    public function reviewInsert(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'product_id' => 'required',
            'review' => 'required',
        ]);
        $user_id = Auth::id();
        $orderDetails = OrderDetail::where('product_id', $request->product_id)->where('order_id', $request->order_id)->where('user_id', $user_id)->first();
        if($orderDetails) {
            $review = Review::where('user_id', $user_id)->where('order_id', $request->order_id)->where('product_id', $request->product_id)->first();
            if(!$review){
                $review = new Review();
            }
            $review->user_id = $user_id;
            $review->vendor_id = $orderDetails->vendor_id;
            $review->order_id = $request->order_id;
            $review->product_id = $request->product_id;
            $review->ratting = ($request->ratting) ? $request->ratting : 0;
            $review->review = $request->review;
            $review->status = 1;
            $save = $review->save();
            if ($save) {
                //if image set
                if ($request->hasFile('review_image')) {
                    $images = $request->file('review_image');
                    foreach ($images as $image) {
                        $new_image_name = $this->uniqueImagePath('review_image_videos', 'review_image', $image->getClientOriginalName());
                        $image->move(public_path('upload/review'), $new_image_name);
                        $review_image = new ReviewImageVideo();
                        $review_image->review_image = $new_image_name;
                        $review_image->user_id = Auth::id();
                        $review_image->review_id = $review->id;
                        $review_image->save();
                    }
                }
                //if video set
                if ($request->hasFile('review_video')) {
                    $videos = $request->file('review_video');
                    foreach ($videos as $video) {
                        $new_video_name = $this->uniqueImagePath('review_image_videos', 'review_video', $video->getClientOriginalName());
                        $video->move(public_path('upload/review'), $new_video_name);
                        $review_image = new ReviewImageVideo();
                        $review_image->review_video = $new_video_name;
                        $review_image->user_id = Auth::id();
                        $review_image->review_id = $review->id;
                        $review_image->save();
                    }
                }
                if(!$review) {
                    //insert notification in database
                    Notification::create([
                        'type' => 'review',
                        'fromUser' => $user_id,
                        'toUser' => $orderDetails->vendor_id,
                        'item_id' => $review->id,
                        'notify' => 'customer give a review ',
                    ]);
                }
                Toastr::success('Thanks for your review.');
            } else {
                Toastr::error('Sorry your review sending failed.!');
            }
        }else{
            Toastr::error('Only product purchase users will be able to give reviews!');
        }
        return back();
    }

    public function adminGetReviewForm(Request $request){
        $data['order_id'] = ($request->order_id) ? $request->order_id : null;
        $data['product_id'] = $request->product_id;
        $data['review'] = Review::where('order_id', $request->order_id)->where('product_id', $request->product_id)->first();
        return view('admin.reviews.review-form')->with($data);
    }
    //admin insert customer product review
    public function adminReviewInsert(Request $request)
    {
        $request->validate([
            'order_id' => 'required',
            'product_id' => 'required',
            'review' => 'required',
        ]);

        $orderDetails = OrderDetail::where('product_id', $request->product_id)->where('order_id', $request->order_id)->first();
        if($orderDetails) {
            $user_id = $orderDetails->user_id;
            $review = Review::where('order_id', $request->order_id)->where('product_id', $request->product_id)->first();
            if(!$review){
                $review = new Review();
            }
            $review->user_id = $user_id;
            $review->vendor_id = $orderDetails->vendor_id;
            $review->order_id = $request->order_id;
            $review->product_id = $request->product_id;
            $review->ratting = ($request->ratting) ? $request->ratting : 0;
            $review->review = $request->review;
            $review->status = 1;
            $save = $review->save();
            if ($save) {
                //if image set
                if ($request->hasFile('review_image')) {
                    $images = $request->file('review_image');
                    foreach ($images as $image) {
                        $new_image_name = $this->uniqueImagePath('review_image_videos', 'review_image', $image->getClientOriginalName());
                        $image->move(public_path('upload/review'), $new_image_name);
                        $review_image = new ReviewImageVideo();
                        $review_image->review_image = $new_image_name;
                        $review_image->user_id = Auth::id();
                        $review_image->review_id = $review->id;
                        $review_image->save();
                    }
                }
                //if video set
                if ($request->hasFile('review_video')) {
                    $videos = $request->file('review_video');
                    foreach ($videos as $video) {
                        $new_video_name = $this->uniqueImagePath('review_image_videos', 'review_video', $video->getClientOriginalName());
                        $video->move(public_path('upload/review'), $new_video_name);
                        $review_image = new ReviewImageVideo();
                        $review_image->review_video = $new_video_name;
                        $review_image->user_id = Auth::id();
                        $review_image->review_id = $review->id;
                        $review_image->save();
                    }
                }
                if(!$review) {
                    //insert notification in database
                    Notification::create([
                        'type' => 'review',
                        'fromUser' => $user_id,
                        'toUser' => $orderDetails->vendor_id,
                        'item_id' => $review->id,
                        'notify' => 'customer give a review ',
                    ]);
                }
                Toastr::success('Thanks for your review.');
            } else {
                Toastr::error('Sorry your review sending failed.!');
            }
        }else{
            Toastr::error('Only product purchase users will be able to give reviews!');
        }
        return back();
    }

    //Reply product review
    public function reviewReplyList($review_id){
        $review = Review::with(['review_comments.user:id,name,username,photo', 'review_image_video'])->leftJoin('users', 'reviews.user_id', 'users.id')
            ->leftJoin('products', 'reviews.product_id', 'products.id')
            ->selectRaw('reviews.*, users.name as customer_name, users.username, photo, products.title as product_name,products.feature_image,products.slug')
            ->where('reviews.id', $review_id)->first();

        return view('admin.reviews.review-reply')->with(compact('review'));
    }

    //admin review reply
    public function adminReviewReply(Request $request)
    {
        $request->validate([
            'review_id' => 'required',
            'comment' => 'required',
        ]);

        $review = new ReviewComment();
        $review->user_id = Auth::guard('admin')->id();
        $review->review_id = $request->review_id;
        $review->response_by = 'admin';
        $review->comment = $request->comment;
        $save = $review->save();
        if($save){

        //if image set
        if ($request->hasFile('review_image')) {
            $images = $request->file('review_image');
            foreach($images as $image) {
                $new_image_name = $this->uniqueImagePath('review_image_videos', 'review_image', $image->getClientOriginalName());
                $image->move(public_path('upload/review'), $new_image_name);
                $review_image = new ReviewImageVideo();
                $review_image->review_image = $new_image_name;
                $review_image->user_id = Auth::id();
                $review_image->review_id = $review->id;
                $review_image->save();
            }
        }

            Toastr::success('Review reply success.');
        }else{
            Toastr::error('Sorry review reply failed.!');
        }
        return back();
    }

    //display review in admin panel
    public function reviewList()
    {
        $reviews= Review::leftJoin('users', 'reviews.user_id', 'users.id')
            ->leftJoin('products', 'reviews.product_id', 'products.id')
            ->orderBy('id', 'desc')
            ->selectRaw('reviews.*, users.name as customer_name, users.username, products.title as product_name,products.feature_image,products.slug')->paginate(16);
        return view('admin.reviews.reviews')->with(compact('reviews'));
    }

    //edit review
    public function reviewEdit($review_id)
    {
        //
    }

    //update review
    public function reviewUpdate(Request $request)
    {
        //
    }

    //customer review delete
    public function reviewDelete($review_id)
    {
        $review = Review::find($review_id);
        if($review){
            $review->delete();

            $output = [
                'status' => true,
                'msg' => 'Review deleted successfully.'
            ];
        }else{
            $output = [
                'status' => false,
                'msg' => 'Review cannot deleted.'
            ];
        }
        return response()->json($output);
    }

}
