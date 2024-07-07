<form action={{route('confirm')}} method="post">
    @csrf
    <input type="hidden" name="amount" value="3000">
    <input type="submit" value="Confirm" id="confirm">
</form>
