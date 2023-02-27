<form action="{{ route('reseller.return.store', $order->id) }}" method="post">
    @csrf

    <input type="hidden" name="order_id" value="{{ $order->id }}">
    <div class="my-3">
        <label for="reason">Select Product List</label>
        <select name="product[]" id="" class="form-control js-example-basic-multiple"  multiple="multiple">
            @foreach($order->order_details as $item)
                <option value="{{ $item->product->id }}">{{ $item->product->title }}</option>

            @endforeach
        </select>
    </div>

    <div class="my-3">
        <label for="reason">Return Reason</label>
        <textarea name="reason" id="reason" cols="30" rows="10" class="form-control" placeholder="Ex 550 and 564 Product return"></textarea>

    </div>
    <div class="my-3">
        <button class="btn btn-success" type="submit">Send Request</button>
    </div>

</form>