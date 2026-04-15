<div class="modal fade" id="modalFilter" tabindex="false" role="dialog" aria-labelledby="modalFilterLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFilterLabel">Filter Pencarian</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="get" action="#" id="frmFilter">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pencarian</label>
                        <input type="text" class="form-control" placeholder="Pencarian..." value="{{request()->get('search')}}" name="search">
                    </div>
                    <div class="form-group">
                        <label>Perusahaan</label>
                        <select class="form-control select2" name="company_id">
                            <option value="">==Semua Perusahaan==</option>
                            @foreach($companies as $row)
                            <option value="{{$row->id}}" {{request()->get('company_id') == $row->id ? "selected" : ""}}>{{$row->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
