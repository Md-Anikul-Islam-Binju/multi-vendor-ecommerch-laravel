<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OfferType;
use App\Traits\CreateSlug;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class OfferTypeController extends Controller
{
    use CreateSlug;
    public function offerTypeIndex()
    {
        $data['offerTypes'] = OfferType::withCount(['offers'])->orderBy('position', 'asc')->get();
        return view('admin.offer.offerTypes.offerType')->with($data);
    }


    public function offerTypeStore(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required',
        ]);

        $offer = new OfferType();
        $offer->title = $request->title;
        $offer->sub_title = $request->sub_title;
        $offer->slug = $this->createSlug('offer_types', $request->title);
        $offer->background_color = $request->background_color;
        $offer->text_color = $request->text_color;
        //if feature image set
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $new_image_name = $this->uniqueImagePath('offer_types', 'image', $request->title.'.'.$image->getClientOriginalExtension());
            $image->move(public_path('upload/images/offer/'), $new_image_name);
            $offer->image = $new_image_name;
        }
        //if feature image set
        if ($request->hasFile('banner')) {
            $image = $request->file('banner');
            $new_image_name = $this->uniqueImagePath('offers', 'banner', $request->title.'.'.$image->getClientOriginalExtension());
            $image->move(public_path('upload/images/offer/banner/'), $new_image_name);
            $offer->banner = $new_image_name;
        }
        $offer->status = ($request->status) ? 1 : null;
        $offer->position = 0;
        $store = $offer->save();
        if($store) {
            Toastr::success('Offer type created success.');
        }else{
            Toastr::error('Offer type can\'t create.');
        }
        return back();
    }

    function offerTypeEdit($id)
    {
        $data['data'] = OfferType::find($id);
        if($data['data']){
            return view('admin.offer.offerTypes.offerTypeEdit')->with($data);
        }else{
            return 'Offer not found.';
        }
    }

    public function offerTypeUpdate(Request $request, OfferType $offerType)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $offer = OfferType::find($request->id);
        $offer->title = $request->title;
        $offer->sub_title = $request->sub_title;
        $offer->background_color = $request->background_color;
        $offer->text_color = $request->text_color;
        //if feature image set
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $new_image_name = $this->uniqueImagePath('offer_types', 'image', $image->getClientOriginalName());
            $image->move(public_path('upload/images/offer/'), $new_image_name);
            $offer->image = $new_image_name;
        }
        //if feature image set
        if ($request->hasFile('banner')) {
            $image = $request->file('banner');
            $new_image_name = $this->uniqueImagePath('offers', 'banner', $request->title.'.'.$image->getClientOriginalExtension());
            $image->move(public_path('upload/images/offer/banner/'), $new_image_name);
            $offer->banner = $new_image_name;
        }
        $offer->status = ($request->status) ? 1 : null;
        $store = $offer->save();
        if($store) {
            Toastr::success('Offer type update success.');
        }else{
            Toastr::error('Offer type can\'t update.');
        }
        return back();
    }

    public function offerTypeDelete($id)
    {
        $offer = OfferType::find($id);
        if($offer){
            $thumbnail = public_path('upload/images/offer/' . $offer->image);
            if(file_exists($thumbnail) && $offer->thumbnail){
                unlink($thumbnail);
            }
            $output = [
                'status' => true,
                'msg' => 'Offer type deleted successful.'
            ];
            //delete offer
            $offer->delete();
        }else{
            $output = [
                'status' => false,
                'msg' => 'Offer type cannot deleted.'
            ];
        }
        return response()->json($output);
    }
}
