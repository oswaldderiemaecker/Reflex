@extends('frontend.app')

@section('includes.css')
    @parent
    <link href="/css/custom.css" rel="stylesheet" type="text/css" />
@stop

@section('includes.js')
    @parent

    <script src="/plugins/fittext/jquery.fittext.js"></script>
    <script src="/js/custom.js" type="text/javascript"></script>

    <script type="text/javascript">

        $(document).ready(function(){
            function adjustHeight(){
                $('#lapListCont').height( ($(window).height() - $('#stopWatch').height() - $('#heightlap').height() - 110) + "px") ;
            }
            adjustHeight();
            $(window).on('resize', function(){
                adjustHeight();
            });
            //$('#time').fitText(.6, { minFontSize: '80vmin'});
            var startTime;
            var timeout;
            var pauseTime = 0;
            var mils;
            var paused = false;
            var count = 0;
            $('#time').on('click', function(){
                if(mils != undefined){
                    if(mils > 0){
                        $('#lapInst').hide();
                        var time = milToTime(mils);
                        //alert(mils);
                        time = formatTime(time);
                        count += 1;
                        $('#timeTable thead').show();
                        $('#lapList').prepend('<tr class="timeRow"><td class="lapCount muted">' + count + ".</td><td>" +time.h +':'+time.m +':'+time.s + '.' + time.mils+  '</td></tr>');
                        $('#lapListCont').animate({ scrollTop: 0 }, "fast");
                    }
                }
            });

            $('#btnPause').on('click', function(){
                if(paused == false){
                    paused = true;
                    clearTimeout(timeout);
                    pauseTime = mils;
                    $(this).html('<i class="icon-play-circle"></i>&nbsp;&nbsp;Resume');
                    $('#time').addClass('paused');
                }else{
                    paused = false;
                    $(this).html('<i class="icon-pause"></i>&nbsp;&nbsp;Pause');
                    startTime = new Date();
                    clock();
                }
            });
            $('#btnStop').on('click', function(){
                $('#title').slideDown();
                $('#lapInst').hide();
                $('#time').removeClass('paused');
                paused = false;
                clearTimeout(timeout);
                pauseTime = 0;
                mils = 0;
                $('#time').html('00:00:00');
                $('#btnClear').click();
                $('#divControls').fadeOut(function(){
                    $('#divStart').fadeIn()
                    $('#btnPause').html('<i class="icon-pause"></i>&nbsp;&nbsp;Pause');
                });
            });
            $('#btnStart').on('click', function(){
               /* $('#title').slideUp(function(){
                    adjustHeight();
                });*/
                var btn = $(this);
                startTime = new Date();
                clock();
                $('#divStart').fadeOut(function(){
                    $('#stop').removeClass("hidden");
                    $('#divControls').fadeIn();
                    $('#lapInst').fadeIn();
                    $('#lapTimes').fadeIn();
                });
            });
            function clock() {
                $('#time').removeClass('paused');
                var curTime = new Date();
                mils = (curTime - startTime) + pauseTime;
                var time = milToTime(mils);
                formatTime(time);
                var outStr = time.h +':'+time.m +':'+time.s;
                document.getElementById('time').innerHTML=outStr;
                timeout = setTimeout(clock,20);
            }

            function formatTime(time){
                for(var i in time){
                    if(i == "mils"){
                        if(time[i] < 1){
                            time[i] = "000";
                        }else
                        if(time[i] < 10){
                            time[i] = "00" + time[i];
                        }else
                        if(time[i] < 100){
                            time[i] = "0" + time[i];
                        }
                    }else if(time[i] < 10){
                        time[i] = "0" + time[i];
                    }
                }
                return time;
            }

            function milToTime(mil){
                mi = mil % 1000;
                seconds = parseInt(mil / 1000) % 60;
                minutes = parseInt(mil / 1000 / 60) % 60;
                hours = parseInt( mil / 1000 / 3600);
                return {s: seconds, m: minutes, h:hours, mils:mi};
            }

            $('#btnClear').on('click', function(){
                $('#lapList, #btnClear').fadeOut(function(){
                    $('#lapList').html('').fadeIn();
                    $('#timeTable thead').hide();
                    //$('#lapInst').fadeIn();
                    count = 0;
                });
            });
        });			</script>
    @stop

@section('content')

        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Nueva Visita</h3>
                </div><!-- /.box-header -->
                <div class="box-body">


        <div class="center">
            <div id="stopWatch">
                <h1 id="title">Nueva Visita</h1>
                <div class="">
                    <div class="span12">
                        <div id="time" class="pointable" style="font-weight:bold; width:100%; display:block;">00:00:00</div>
                    </div>
                </div>
                <div class="">
                    <div id="divStart" class="span4 center">
                        <button id="btnStart" class="btn btn-large btn-block btn-primary" style="font-weight:bold;" data-do="start" type="button">Inicio</button>
                    </div>
                </div>
                <div class="" id="divControls">
                    <div class="center">
                        <div class="hidden" id="stop">
										<span class="span2">
											<button id="btnPause" class="btn btn-large btn-block" type="button">
                                                <i class="icon-pause"></i>
                                                &nbsp;&nbsp;Fin
                                            </button>
										</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <div id="lapTimes" class="hidden row center">
                <div class="heightlap" style="margin-top:10px;">
                    <button class="btn hidden" id="btnClear" type="button">Clear</button>
                    <p id="lapInst">Tap the time to record a lap.</p>
                </div>
                <div class="span12 center scrollable" id="lapListCont" style="height:0px;">
                    <div class="row">
                        <div class="span4 center" style="margin-top:5px;">
                            <table id="timeTable" class="table table-striped" style="width:70%; margin:auto;">
                                <thead class="hidden">
                                <tr>
                                    <th>#</th>
                                    <th>Time</th>
                                </tr>
                                </thead>
                                <tbody id="lapList"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- /.box-body -->
</div><!-- /.box -->
@endsection
