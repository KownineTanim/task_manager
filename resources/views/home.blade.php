@extends('Layout.app')
@section('title','Home')
@section('content')


<form action="/action_page.php" id="carform">
  <label for="fname">Firstname:</label>
  <input type="text" id="fname" name="fname">
  <label for="cars">Choose a car:</label>
  <select id="cars" name="carlist" form="carform" style="display:block!important">
    <option value="volvo">Volvo</option>
    <option value="saab">Saab</option>
    <option value="opel">Opel</option>
    <option value="audi">Audi</option>
  </select>
  <input type="submit">
</form>




<p>The drop-down list is defined outside the form element, but will be submitted with the form.</p>
@endsection

@section('script')
<script type="text/javascript">


</script>
@endsection