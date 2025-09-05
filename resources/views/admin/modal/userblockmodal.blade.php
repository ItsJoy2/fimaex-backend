<div class="modal fade" id="actionModal" tabindex="-1" role="dialog" aria-labelledby="actionModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{route('users.update')}}" method="POST">
            @csrf
            <input type="hidden" name="user_id" id="modal_user_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update User and Wallet Status</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" id="modal_user_name" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" name="email" id="modal_user_email" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label>Wallet</label>
                        <input type="text" name="wallet" id="modal_user_wallet" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>User Status</label>
                        <select id="modal_block_status" class="form-control" name="is_block">
                            <option value="0">Unblock</option>
                            <option value="1">Block</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</div>

