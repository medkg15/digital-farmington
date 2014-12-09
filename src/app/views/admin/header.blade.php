    <div class="panel panel-default">
        <div class="panel-heading" role="tab" id="headingOne">
            <h4 class="panel-title">
                <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Administration
                    <span class="pull-right">
                    <i class="glyphicon glyphicon-plus">/</i><i class="glyphicon glyphicon-minus"></i>
                    </span></a>
                </a>
            </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
            <div class="panel-body">

                <div class="row">

                    <div class="col-md-3">
                        <a href="{{ action('MapController@displayAdmin') }}">
                        <div class="well" style="text-align: center">
                        <span class="glyphicon glyphicon-map-marker" style="font-size:50px;"></span><br/>
                        View Map
                        </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{action('ListController@showList')}}">
                        <div class="well" style="text-align: center">
                            <span class="glyphicon glyphicon-align-justify" style="font-size:50px;"></span><br/>
                            View Points of Interest
                        </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{action('PointOfInterestController@showEdit')}}">
                        <div class="well" style="text-align: center">
                            <span class="glyphicon glyphicon-pencil" style="font-size:50px;"></span><br/>
                            Add Point of Interest
                        </div>
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="{{ action('CategoryController@show')}}">
                        <div class="well" style="text-align: center">
                            <span class="glyphicon glyphicon-tags" style="font-size:50px;"></span><br/>
                            Manage Categories
                        </div>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>