<form action="{{ route('order.return.approve.form.update', $returnRequest) }}" method="post">
    @csrf
    <div class="my-3">
        <label for="amount">Enter Return Cost</label>
        <input type="text" name="amount" class="form-control">
        <small>It will reduce form reseller account</small>
    </div>
    <div class="my-3">
        <button type="submit" class="btn btn-success">Approve</button>
    </div>
</form>
