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
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Mulai Tanggal</label>
                                <input type="date" class="form-control" placeholder="Mulai Tanggal" value="{{request()->get('from_date')}}" name="from_date">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Sampai Tanggal</label>
                                <input type="date" class="form-control" placeholder="Sampai Tanggal" value="{{request()->get('to_date')}}" name="to_date">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Pencarian</label>
                        <input type="text" class="form-control" placeholder="Pencarian..." value="{{request()->get('search')}}" name="search">
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
