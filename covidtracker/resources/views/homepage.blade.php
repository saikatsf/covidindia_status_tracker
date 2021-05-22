{{---------- For Links ----------}}
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>

{{---------- For api Certification ----------}}
<?php
    $stream_opts = [
    "ssl" => [
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ]
    ];
    $data = file_get_contents('https://api.covid19india.org/data.json',false, stream_context_create($stream_opts));
    $coronalive = json_decode($data, true);
    $statescount = count($coronalive['statewise']);
?>

{{---------- For Header ----------}}

<nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <img src="{{ URL::to('/img/covid.png') }}" alt="" width="30" height="30" class="d-inline-block align-text-top">
            COVID-19 Tracker
          </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#statecount">Tracker</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#symptoms">Symptoms</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#about">About</a>
          </li>
        </ul>
      </div>
    </div>
</nav>

{{---------- For Top Content ----------}}

<div class="row text-center w-100 mt-4">
    <div class="col-lg-4 col-md-4 col-12">
        <h1>
            Lets Fight This
            <br><img src="{{ URL::to('/img/covid-19.png') }}" alt="" width="60" height="60" style="margin-top: 5px"><br>
            Together
        </h1>
    </div>
    <div class="col-lg-4 col-md-4 col-12">
        <h1>Always Use A Mask</h1>
        <img src="{{ URL::to('/img/mask.png') }}" alt="" width="60" height="60" style="margin-top: 5px"><br>
    </div>
    <div class="col-lg-4  col-md-4 col-12">
        <h1>Keep Your Hands Clean</h1>
        <img src="{{ URL::to('/img/handwash.png') }}" alt="" width="60" height="60" style="margin-top: 5px"><br>
        <h3>Use Handwash & Sanitizers</h3>
    </div>
</div>
<hr>

{{---------- For LiveCount ----------}}

<section id="livecount">
    <div class="text-center mb-4 mt-2">
        <h3>COVID-19 INDIA UPDATES</h3>
    </div>
    <div class="d-flex justify-content-around text-center" id="totalcount">
        <div class="text-primary countback" id="tconfirmed">
            + {{$coronalive['statewise'][0]['deltaconfirmed']}}
            <h1>{{$coronalive['statewise'][0]['confirmed']}}</h1>
            <p>Confirmed</p>
        </div>
        <div class="text-info countback" id="tactive">
            <br>
            <h1>{{$coronalive['statewise'][0]['active']}}</h1>
            <p>Active</p>
        </div>
        <div class="text-success countback" id="trecovered">
            + {{$coronalive['statewise'][0]['deltarecovered']}}
            <h1>{{$coronalive['statewise'][0]['recovered']}}</h1>
            <p>Recovered</p>
        </div>
        <div class="text-danger countback" id="tdeaths">
            + {{$coronalive['statewise'][0]['deltadeaths']}}
            <h1>{{$coronalive['statewise'][0]['deaths']}}</h1>
            <p>Deceased</p>
        </div>
    </div>
    <div style="float: right; margin-right:10px; font-size:10px;">
        *Last Updated on : {{ $coronalive['statewise'][0]['lastupdatedtime'] }}
    </div>
</section>
<hr>

{{---------- For StateWise Count ----------}}
<h1 class="text-center text-secondary" id="statecount">Statewise Count</h1>
<br>
<div class="container-fluid" style="overflow-x:auto;">
    <table class="table table-striped text-center">
        <thead>
            <tr>
              <th>State</th>
              <th>Confirmed</th>
              <th>Active</th>
              <th>Recovered</th>
              <th>Deceased</th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 1; $i < $statescount; $i++)
                @if( $coronalive['statewise'][$i]['statecode'] == "UN")
                    @php
                        continue;
                    @endphp
                 @endif
                <tr class="align-middle text-secondary">
                    <td>{{ $coronalive['statewise'][$i]['state'] }}</td>
                    <td>
                        <span id="smallspan" class="text-info">
                            @if($coronalive['statewise'][$i]['deltaconfirmed'] != "0")
                            + {{ $coronalive['statewise'][$i]['deltaconfirmed'] }}
                            <br>
                            @endif
                        </span>
                        {{ $coronalive['statewise'][$i]['confirmed'] }}
                        
                    </td>
                    <td>
                        {{ $coronalive['statewise'][$i]['active'] }}

                    </td>
                    <td>
                        <span id="smallspan" class="text-primary">
                            @if($coronalive['statewise'][$i]['deltarecovered'] != "0")
                            + {{ $coronalive['statewise'][$i]['deltarecovered'] }}
                            <br>
                            @endif
                        </span>
                        {{ $coronalive['statewise'][$i]['recovered'] }}
                    </td>
                    <td>
                        <span id="smallspan" class="text-danger">
                            @if($coronalive['statewise'][$i]['deltadeaths'] != "0")
                            + {{ $coronalive['statewise'][$i]['deltadeaths'] }}
                            <br>
                            @endif
                        </span>
                        {{ $coronalive['statewise'][$i]['deaths'] }}
                    </td>
                </tr>
            @endfor
        </tbody>
    </table>
</div>

{{---------- For Symptoms section ----------}}
<hr>
<div id="symptoms" class="container text-center">
    <h1 >COVID-19 SYMPTOMS</h1>
    <br>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-12">
            <figure class="mt-2">
                <img src="{{ URL::to('/img/fever.png') }}" height="100px" width="100px" alt="">
                <figcaption class="mt-2">Fever</figcaption>
            </figure>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <figure class="mt-2">
                <img src="{{ URL::to('/img/coughing.png') }}" height="100px" width="100px" alt="">
                <figcaption class="mt-2">Cough</figcaption>
            </figure>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <figure class="mt-2">
                <img src="{{ URL::to('/img/tired.png') }}" height="100px" width="100px" alt="">
                <figcaption class="mt-2">Tiredness</figcaption>
            </figure>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <figure class="mt-2">
                <img src="{{ URL::to('/img/breathing.png') }}" height="100px" width="100px" alt="">
                <figcaption class="mt-2">Difficulty In Breathing</figcaption>
            </figure>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <figure class="mt-2">
                <img src="{{ URL::to('/img/no-taste.png') }}" height="100px" width="100px" alt="">
                <figcaption class="mt-2">Loss Of Taste</figcaption>
            </figure>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <figure class="mt-2">
                <img src="{{ URL::to('/img/runny-nose.png') }}" height="100px" width="100px" alt="">
                <figcaption class="mt-2">Runny Nose</figcaption>
            </figure>
        </div>

    </div>
    <br>
    <h6>[ If you have this symptoms contact your nearby hospital or the State Government COVID helpline number. ]</h3>
</div>
<hr>

{{---------- For About ----------}}
<div class="container-fluid text-light bg-dark" id="about">
    <div class="row">
        <div class="col-lg-6 col-md-6 col-12">
            <img src="{{ URL::to('/img/coronavirus.png') }}" height="428px" width="544px" id="covidimg" alt="">
        </div>
        <div class="col-lg-6 col-md-6 col-12" style="margin-top: 50px">
            <h1>About COVID-19</h1><br>
            <p>Coronavirus disease (COVID-19) is an infectious disease caused by a newly discovered coronavirus.<br>
                Most people infected with the COVID-19 virus will experience mild to moderate respiratory illness and recover without requiring special treatment.
                Older people, and those with underlying medical problems like cardiovascular disease, diabetes, chronic respiratory disease, and cancer are more likely to develop serious illness. <br>
                The best way to prevent and slow down transmission is to be well informed about the COVID-19 virus, the disease it causes and how it spreads.Protect yourself and others from infection by washing your hands or using an alcohol based rub frequently and not touching your face.
                The COVID-19 virus spreads primarily through droplets of saliva or discharge from the nose when an infected person coughs or sneezes, so it’s important that you also practice respiratory etiquette (for example, by coughing into a flexed elbow).</p>
        </div>
    </div>
    <br>
    <hr>
    <div class="text-center row">
        <div class="col-lg-4 col-md-4 col-12">
            Data source : <a href="https://www.covid19india.org">covid19india.org</a>
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            &#169; 2021 Saikat Fouzdar
        </div>
        <div class="col-lg-4 col-md-4 col-12">
            <a href="https://mohfw.gov.in
            ">Ministry of Health and Family Welfare</a>
        </div>
        
        <hr>
    </div> 
</div>

<button onclick="topFunction()" id="myBtn" title="Go to top">&uarr; Go to Top</button>

{{---------- For CSS ----------}}
<style>
    @media(max-width:768px){
      #totalcount{
          display: inline!important;
      }
    }
    @media(max-width:550px){
        #covidimg{
            height: 214px;
            width: 272px;
        }
    }
    #myBtn {
        display: none;
        position: fixed;
        bottom: 20px;
        right: 30px;
        z-index: 99;
        font-size: 10px;
        border: none;
        outline: none;
        background-color: red;
        color: white;
        cursor: pointer;
        padding:10px;
        border-radius: 4px;
    }
    #myBtn:hover {
        background-color: #555;
    }
    #smallspan{
        font-size: 10px;
    }
    .countback{
        border-radius:10px;
        padding:20px;
    }
    #tconfirmed:hover{
        background :rgba(2, 117, 216,0.4);
    }
    #tactive:hover{
        background :rgba(91, 192, 222, 0.4);
    }
    #trecovered:hover{
        background :rgba(92, 184, 92, 0.4);
    }
    #tdeaths:hover{
        background :rgba(217, 83, 79, 0.4);
    }
</style>

<script>
    var mybutton = document.getElementById("myBtn");
    window.onscroll = function() {scrollFunction()};
    function scrollFunction() {
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            mybutton.style.display = "block";
        }
        else {
            mybutton.style.display = "none";
        }
    }

    function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
    }
</script>