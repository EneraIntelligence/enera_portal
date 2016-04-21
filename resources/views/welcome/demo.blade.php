@extends('layouts.main')
@section('head_scripts')
{!! HTML::style(asset('css/demo.css')) !!}

        <!-- branch colors -->
<style>
    body {
        background-color: #e8eaf6;
    }

    footer.page-footer {
        background-color: #3f51b5;
    }
</style>
@stop

@section('header')
    <nav>
        <div class="nav-wrapper indigo z-depth-2">
            <a href="#!" class="brand-logo">Enera Demo</a>
        </div>
    </nav>
    @stop

    @section('content')

            <!-- Main card -->
    <div class="container">

        <div class="card-panel center welcome">
            <h4>Bienvenido a Enera WiFi.</h4>
            <p>Selecciona un demo</p>
        </div>
    </div>

        <div class="row">
            <div class="col s12 m6 l4">
                <a href="{{url("demo/like")}}">

                    <div class="card-panel center">
                        <svg style="height:115px; fill: #737373; stroke: #737373" viewBox="-10 -20 140 160">
                            <g>
                                <path id="hand" fill="none" stroke="" stroke-width="4" stroke-linecap="round"
                                      stroke-linejoin="round" stroke-miterlimit="10" d="
	M65.638,112.37c-14.427-0.831-29.221-6.627-32.031-6.82c-0.908,0.127-2.046,0.193-3.174,0.193H23.19
	c-11.167,0-18.128-4.346-18.128-11.521V58.547c0-7.678,6.783-11.524,18.128-11.524h7.242c3.994,0,5.992,0.643,5.992,0.643
	s7.215-11.442,16.497-16.477C59.54,27.6,63.716,22.447,64.854,19.06c0.193-0.575,0.46-1.597,0.41-2.685
	c-0.185-4.033-0.059-10.668,4.644-11.402c1.169-0.186,2.548-0.404,3.9-0.257c5.558,0.602,10.346,6.617,10.701,11.267
	c0.361,4.722,0.068,13.157-8.602,19.534c-1.596,1.174-3.08,3.072-2.644,4.455s2.616,2.657,5.272,2.447
	c0,0,10.977,0.007,18.465,0.477s14.652,2.216,14.967,10.591c0.014,0.316,0.274,7.32-4.123,10.213
	c1.449,1.732,3.882,5.264,3.627,9.225c-0.167,2.604-1.449,4.918-3.817,6.891c0.983,1.92,3,6.652,1.464,10.764
	c-0.851,2.277-2.625,3.976-5.279,5.066c0.505,1.328,1.006,3.604-0.024,6.16c-1.764,4.373-10.64,8.131-15.666,9.234
	C83.397,112.083,79.231,113.153,65.638,112.37z"/>
                            </g>
                        </svg>
                        <h5>Like</h5>

                    </div>
                </a>

            </div>

            <div class="col s12 m6 l4">
                <a href="{{url("demo/banner_link")}}">

                    <div class="card-panel center">

                        <svg style="height:115px; fill: #737373; stroke: #737373" viewBox="35 30 125 140">
                            <g>
                                <path fill="none" stroke-width="4" stroke-miterlimit="10" d="M134.193,85.552v70.019
		c0,4.375-3.547,7.923-7.922,7.923H72.864c-4.374,0-7.921-3.548-7.921-7.923V44.428c0-4.375,3.547-7.92,7.921-7.92h53.408
		c4.375,0,7.922,3.545,7.922,7.92v9.032"/>
                                <polyline fill="none" stroke-width="2.2" stroke-miterlimit="10" points="125.855,85.552 125.855,144.273
		73.28,144.273 73.28,45.309 125.855,45.309 125.855,53.465 	"/>
                                <circle fill="none" stroke-width="2.2" stroke-miterlimit="10" cx="99.303" cy="154.123"
                                        r="4.887"/>
                                <g id="chain">
                                    <path d="M147.548,59.555h-4.057c1.278,1.12,2.346,2.475,3.131,4h0.926c3.588,0,6.509,2.521,6.509,5.62
			c0,3.099-2.921,5.62-6.509,5.62h-10.985c-3.183,0.029-8.136-3.174-5.99-8.596h-4.08c-0.877,3.906-0.205,6.969,2.27,9.414
			c1.949,1.926,4.707,3.182,7.801,3.182h10.986c5.795,0,10.508-4.315,10.508-9.62C158.057,63.87,153.343,59.555,147.548,59.555z"/>
                                    <path d="M126.827,77.568c-0.438-0.434-0.826-0.889-1.183-1.355h-2.021c-3.588,0-6.506-2.92-6.506-6.507
			c0-3.588,2.918-6.507,6.506-6.507h10.987c3.589,0,6.507,2.919,6.507,6.507c0,0.519-0.119,1.359-0.302,2.208h4.072
			c0.137-0.781,0.229-1.564,0.229-2.208c0-5.794-4.713-10.507-10.507-10.507h-10.987c-5.793,0-10.506,4.713-10.506,10.507
			s4.713,10.507,10.506,10.507h7.008C129.238,79.556,127.95,78.678,126.827,77.568z"/>
                                </g>
                                <line fill="none" stroke-width="2.2" stroke-miterlimit="10" x1="81.45" y1="87.256"
                                      x2="116.766" y2="87.256"/>
                                <line fill="none" stroke-width="2.2" stroke-miterlimit="10" x1="81.45" y1="96.342"
                                      x2="116.766" y2="96.342"/>

                                <line fill="none" stroke-width="2.2" stroke-miterlimit="10" x1="125.491" y1="127.697"
                                      x2="74.014" y2="127.697"/>
                            </g>
                        </svg>
                        <h5>Banner+Link</h5>
                    </div>
                </a>

            </div>

            <div class="col s12 m6 l4">
                <a href="{{url("demo/mailing_list")}}">

                    <div class="card-panel center">

                        <svg style="height:115px; fill: #737373; stroke: #737373" viewBox="40 35 120 120">
                            <g id="mail">

                                <polyline fill="none" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-miterlimit="10" points="
		148.473,85.556 148.473,146.82 51.528,146.82 51.528,85.556 	"/>

                                <polyline fill="none" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-miterlimit="10" points="
		51.528,85.556 100.182,124.117 148.473,85.556 	"/>

                                <polyline fill="none" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-miterlimit="10" points="
		148.473,85.556 99.46,46.994 51.528,85.556 	"/>

                                <line fill="none" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-miterlimit="10" x1="51.528" y1="146.82" x2="89.729" y2="116.189"/>

                                <line fill="none" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-miterlimit="10" x1="148.111" y1="145.74" x2="112.073" y2="116.189"/>

                                <polyline id="mail_sheet" fill="none" stroke-width="4" stroke-linecap="round"
                                          stroke-linejoin="round" stroke-miterlimit="10" points="
		126.389,103.143 126.389,77.968 73.469,77.968 73.469,102.039 	"/>
                                <g id="mail_lines">
                                    <line fill="none" stroke-width="2.2" stroke-miterlimit="10" x1="82.474" y1="89.728"
                                          x2="117.202" y2="89.728"/>
                                    <line fill="none" stroke-width="2.2" stroke-miterlimit="10" x1="82.474" y1="95.943"
                                          x2="117.202" y2="95.943"/>
                                </g>
                            </g>
                        </svg>
                        <h5>Mailing list</h5>
                    </div>
                </a>

            </div>

            <div class="col s12 m6 l4">
                <a href="{{url("demo/captcha")}}">

                    <div class="card-panel center">

                        <svg style="max-width:100%; height:115px; fill: #737373; stroke: #737373"
                             viewBox="0 35 200 120">
                            <g>
                                <path fill="none" stroke-width="4" stroke-miterlimit="10" d="M149.26,94.208h30.807
		c4.976,0,7.922,3.325,7.922,9.806v20.233c0,4.376-3.547,7.924-7.922,7.924H88.91c-6.291,0-8.426-3.69-8.426-9.17
		c0-0.733-0.018-1.897-0.018-1.897"/>
                                <circle fill="none" stroke-width="4" stroke-miterlimit="10" cx="30.879" cy="98.427"
                                        r="7.549"/>
                                <g>
                                    <g>
                                        <path stroke-width="0" d="M42.607,67.829c13.203,0,24.453,8.362,28.742,20.08h33.766v-8.881c0-2.453,1.988-4.441,4.441-4.441
				c2.452,0,4.44,1.988,4.44,4.441v8.881h10.047v-4.97c0-2.453,1.988-4.441,4.44-4.441c2.453,0,4.441,1.988,4.441,4.441v5.82
				c3.748,1.609,6.373,5.33,6.373,9.667c0,5.809-4.709,8.316-10.518,8.316H71.35c-1.891,12.99-15.539,22.281-28.742,22.281
				c-16.898,0-30.596-13.699-30.596-30.599C12.012,81.526,25.709,67.829,42.607,67.829 M42.607,63.829
				c-19.076,0-34.596,15.521-34.596,34.598c0,19.078,15.52,34.599,34.596,34.599c7.322,0,14.978-2.573,21.002-7.062
				c5.451-4.062,9.253-9.374,10.954-15.221h54.22c8.818,0,14.518-4.834,14.518-12.316c0-4.877-2.433-9.351-6.373-12.019V82.94
				c0-4.655-3.787-8.441-8.441-8.441c-4.653,0-8.44,3.787-8.44,8.441v0.97h-2.047v-4.881c0-4.655-3.787-8.441-8.44-8.441
				c-4.654,0-8.441,3.787-8.441,8.441v4.881H74.02C68.408,71.792,56.121,63.829,42.607,63.829L42.607,63.829z"/>
                                    </g>
                                </g>
                                <g id="exe1">
                                    <path fill="none" stroke-width="4" stroke-miterlimit="10" d="M145.547,109.15"/>

                                    <line fill="none" stroke-width="4" stroke-miterlimit="10" x1="145.547" y1="120.777"
                                          x2="157.172" y2="109.15"/>

                                    <line fill="none" stroke-width="4" stroke-miterlimit="10" x1="145.547" y1="109.15"
                                          x2="157.172" y2="120.777"/>
                                </g>
                                <g id="exe2">
                                    <path fill="none" stroke-width="4" stroke-miterlimit="10" d="M167.699,109.15"/>

                                    <line fill="none" stroke-width="4" stroke-miterlimit="10" x1="167.699" y1="120.777"
                                          x2="179.324" y2="109.15"/>

                                    <line fill="none" stroke-width="4" stroke-miterlimit="10" x1="167.697" y1="109.15"
                                          x2="179.324" y2="120.777"/>
                                </g>
                            </g>
                        </svg>
                        <h5>Captcha</h5>
                    </div>
                </a>

            </div>

            <div class="col s12 m6 l4">
                <a href="{{url("demo/encuesta")}}">

                    <div class="card-panel center">

                        <svg style="height:115px; fill: #737373; stroke: #737373" viewBox="50 35 100 130">
                            <g>
                                <g>
                                    <path fill="none" stroke-width="4" stroke-miterlimit="10" d="M132.842,52.108h-5.148v3.893
			c0,2.909-2.359,5.269-5.271,5.269c-2.907,0-5.269-2.359-5.269-5.269v-3.893h-11.887v3.893c0,2.909-2.358,5.269-5.27,5.269
			s-5.269-2.359-5.269-5.269v-3.893H82.843v3.893c0,2.909-2.357,5.269-5.268,5.269c-2.911,0-5.269-2.359-5.269-5.269v-3.893h-5.147
			c-3.986,0-7.217,3.23-7.217,7.216v90.513c0,3.983,3.23,7.218,7.217,7.218h65.683c3.985,0,7.217-3.232,7.217-7.218V59.324
			C140.059,55.339,136.827,52.108,132.842,52.108z"/>
                                    <path fill="none" stroke-width="4" stroke-miterlimit="10" d="M127.691,52.108v-3.894
			c0-2.91-2.358-5.269-5.27-5.269c-2.908,0-5.268,2.358-5.268,5.269v3.894"/>
                                    <path fill="none" stroke-width="4" stroke-miterlimit="10" d="M105.268,52.108v-3.894
			c0-2.91-2.357-5.269-5.269-5.269s-5.269,2.358-5.269,5.269v3.894"/>
                                    <path fill="none" stroke-width="4" stroke-miterlimit="10" d="M82.843,52.108v-3.894
			c0-2.91-2.357-5.269-5.268-5.269c-2.911,0-5.269,2.358-5.269,5.269v3.894"/>
                                </g>
                                <line id="s_line1" fill="none" stroke-width="2.2" stroke-miterlimit="10" x1="84.594"
                                      y1="80.688" x2="128.665" y2="80.688"/>
                                <line fill="none" stroke-width="2.2" stroke-miterlimit="10" x1="71.646" y1="80.688"
                                      x2="76.495" y2="80.688"/>

                                <line id="s_line2" fill="none" stroke-width="2.2" stroke-miterlimit="10" x1="84.594"
                                      y1="93.887" x2="128.665" y2="93.887"/>
                                <line fill="none" stroke-width="2.2" stroke-miterlimit="10" x1="71.646" y1="93.887"
                                      x2="76.495" y2="93.887"/>

                                <line id="s_line3" fill="none" stroke-width="2.2" stroke-miterlimit="10" x1="84.594"
                                      y1="107.085" x2="128.665" y2="107.085"/>
                                <line fill="none" stroke-width="2.2" stroke-miterlimit="10" x1="71.646" y1="107.085"
                                      x2="76.495" y2="107.085"/>

                                <line id="s_line4" fill="none" stroke-width="2.2" stroke-miterlimit="10" x1="84.594"
                                      y1="120.284" x2="128.665" y2="120.284"/>
                                <line fill="none" stroke-width="2.2" stroke-miterlimit="10" x1="71.646" y1="120.284"
                                      x2="76.495" y2="120.284"/>

                                <line id="s_line5" fill="none" stroke-width="2.2" stroke-miterlimit="10" x1="84.594"
                                      y1="133.482" x2="128.665" y2="133.482"/>
                                <line fill="none" stroke-width="2.2" stroke-miterlimit="10" x1="71.646" y1="133.482"
                                      x2="76.495" y2="133.482"/>
                            </g>
                        </svg>
                        <h5>Encuesta</h5>
                    </div>
                </a>

            </div>

            <div class="col s12 m6 l4">
                <a href="{{url("demo/video")}}">

                    <div class="card-panel center">

                        <svg style="height:115px; fill: #737373; stroke: #737373" viewBox="50 45 100 110">
                            <g>
                                <circle fill="none" stroke-width="4" stroke-miterlimit="10" cx="100" cy="100"
                                        r="47.233"/>


                                <polygon id="play_btn" fill="none" stroke-width="4" stroke-linecap="round"
                                         stroke-linejoin="round" stroke-miterlimit="10" points="
		89.434,81.185 89.434,120.111 123.657,100.648 	"/>
                            </g>
                        </svg>
                        <h5>Video</h5>
                    </div>
                </a>

            </div>
        </div>

    <!-- Main card -->



@stop

@section('footer')


    <div class="footer-copyright">
        <div class="container">
            <a class="grey-text text-lighten-4 right" href="http://enera.mx" target="_blank">© 2016 Enera
                Intelligence</a>
        </div>
    </div>

@stop

@section('footer_scripts')


@stop


