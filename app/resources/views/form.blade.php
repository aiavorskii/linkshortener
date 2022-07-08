@extends('layout')

@section('content')
<h1 class="text-center mt-5">Link shortener</h1>
<form id="link-form">
    {{-- make components --}}
    {{-- Put into centered wrapper --}}
    <div class="mb-3">
      <label for="" class="form-label">URL</label>
      <input type="text"
        class="form-control" name="url" id="url" aria-describedby="helpId" placeholder="">
      <small id="url-help" class="form-text text-muted">Enter URL</small>
    </div>
    <div class="mb-3">
      <label for="" class="form-label">Lifetime</label>
      <input type="number"
        class="form-control" name="lifetime" id="lifetime" aria-describedby="helpId" placeholder="">
      <small id="helpId" class="form-text text-muted">Link lifetime in minutes</small>
    </div><div class="mb-3">
      <label for="" class="form-label">Hit count</label>
      <input type="number"
        class="form-control" name="hit_limit" id="hit_limit" aria-describedby="helpId" placeholder="">
      <small id="helpId" class="form-text text-muted">0 - unlimited</small>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

@endsection

