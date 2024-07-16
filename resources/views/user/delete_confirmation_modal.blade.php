<div class="modal fade" id="deleteConfirmation" tabindex="-1" aria-labelledby="deleteConfirmationLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h1 class="modal-title fs-5" id="deleteConfirmationLabel"> Are you sure you want to Delete your Account? </h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p> Deleting your account only removes the information on this website. Your Google account will remain unchanged </p>
        <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">No, close this window (recommended) </button>
        <a class="btn btn-link text-right" data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
          Yes, I'm sure
        </a>
      </div>
      <div class="collapse" id="collapseExample">
        <div class="card card-body">
          <form method="post" action="/user/delete/{{ Auth::user()->id }}">
            <div class="mb-3">
              @csrf
              <label for="deleteConfirmationCode" class="form-label"> Type the following code to allow this action: <span id="deleteCode">{{ substr(Auth::user()->vendor_id, 0, 5) }}</span> </label>
              <input type="text" maxlength="5" class="form-control" id="deleteConfirmationCode" name="deleteConfirmationCode" aria-describedby="deleteConfirmationCode">
            </div>
            <button id="submitDelete" type="submit" class="btn btn-primary" disabled>Confirm Deletion</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>