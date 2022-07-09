@extends('layout')

@section('content')
    <h1 class="text-center mt-5">Link shortener</h1>
    <form id="link-form">
        {{-- make components --}}
        {{-- Put into centered wrapper --}}
        <div class="mb-3">
            <label for="" class="form-label required">URL</label>
            <input type="text" class="form-control " name="url" id="url" aria-describedby="helpId" placeholder="" required>
            <small id="url-help" class="form-text text-muted">Enter URL</small>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Lifetime</label>
            <input type="number" class="form-control" name="lifetime" id="lifetime" aria-describedby="helpId"
                placeholder="">
            <small id="helpId" class="form-text text-muted">Link lifetime in minutes</small>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Hit count</label>
            <input type="number" class="form-control" name="hit_limit" id="hit_limit" aria-describedby="helpId"
                placeholder="">
            <small id="helpId" class="form-text text-muted">0 - unlimited</small>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection

@section('modals')
    <!-- Modal -->
    <div class="modal fade" id="link-modal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">URL</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Body
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="url" id="copy-field" placeholder=""
                            aria-label="" value="" disabled>
                        <span class="input-group-btn">
                            <button id="clipboard-copy-button" class="btn btn-secondary" type="button"
                                aria-label="">Copy</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
