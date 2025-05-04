@extends('layout')

@section('style')
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Cairo">

@endsection

@section('content')
    <main id="profile-page">
        <div class="container" style="margin-top: 10px;">
            <h1 class="w-100  text-dark py-5 mb-0 px-3">
                {{ __('Profile') }}
            </h1>
            <!-- Nav tabs -->
            <ul class="nav nav-tabs position-sticky top-0">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#personal-information">{{__('personal information')}}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " data-bs-toggle="tab" href="#orders">{{__('orders')}}</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link btn-points" data-bs-toggle="tab" href="#points">{{__('points')}}</a>
                </li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane container active row" id="personal-information">
                    <div class="col-12 col-md-6 my-4">
                        <form class="row g-3 needs-validation" novalidate>
                            <div class=" col-12">
                                <label for="validationCustom01" class="form-label">Full name</label>
                                <input type="text" class="form-control" id="validationCustom01" placeholder="Full name" required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class=" col-12">
                                <label for="validationCustom02" class="form-label">Phone</label>
                                {{--                            pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}"--}}
                                <input type="tel" class="form-control" id="validationCustom02" placeholder="Phone"  required>
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            <div class="col-12">
                                <h3>The Address</h3>
                            </div>
                            <div class="col-12">
                                <label for="validationCustom04" class="form-label">Emirate/Province</label>
                                <select class="form-select" id="validationCustom04" required>
                                    <option selected disabled value="">Emirate 1</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a valid Emirate / Province.
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label for="validationCustom05" class="form-label">Full Address</label>
                                <input type="text" class="form-control" id="validationCustom05" placeholder="Full Address" required>
                                <div class="invalid-feedback">
                                    Please provide a valid Full Address.
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-primary w-100" type="submit">Submit form</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane container fade" id="orders">This is a orders tab.</div>

                <div class="tab-pane container fade" id="points">
                    <div class="row h-100">
                        <div class="col-12 col-md-6 h-100 content d-flex align-items-start justify-content-center flex-column ">
                            <p>Great job, <span class="name" id="name">Mr. Rami</span></p>
                            <p>
                                You have <span id="number-of-points">34</span> points in your balance
                                Contribute more to get more points to be able
                                Use it on your next purchase.
                            </p>
                            <div>
                                <button type="button" class="btn text-white bg-primary  btn-Create-order my-4 " data-bs-toggle="tooltip" data-bs-placement="bottom" title="Create a new order">
                                    Create a new order
                                </button></a>
                            </div>
                            <div>
                                <p>Use your points now with your current purchases.</p>
                            </div>
                            <div>
                                <button type="button" class="btn text-white  bg-dark btn-Use-my-points my-4" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Use my points">
                                    Use my points
                                </button></a>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 h-100 d-flex align-items-center justify-content-center">
                            <div class="position-relative">
                                <div class="container progres chart position-relative" data-size="300" data-value="34">
                                    <span class="position-absolute number-of-point-span">{{__('point')}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection

@section('script')
    <script>
         {{--form validation--}}
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (() => {
            'use strict'
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation')
            // Loop over them and prevent submission
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
    <script>
        class Dial {
            constructor(progres) {
                this.progres = progres;
                this.size = this.progres.dataset.size;
                this.strokeWidth = this.size / 8;
                this.radius = this.size / 2 - this.strokeWidth / 2;
                this.value = this.progres.dataset.value;
                this.direction = this.progres.dataset.arrow;
                this.svg;
                this.defs;
                this.slice;
                this.overlay;
                this.text;

                this.create();
            }

            create() {
                this.createSvg();
                this.createDefs();
                this.createSlice();
                this.createOverlay();
                this.createText();

                this.progres.appendChild(this.svg);
            }

            createSvg() {
                let svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
                svg.setAttribute("width", `${this.size}px`);
                svg.setAttribute("height", `${this.size}px`);
                this.svg = svg;
            }

            createDefs() {
                var defs = document.createElementNS("http://www.w3.org/2000/svg", "defs"),
                    linearGradient = document.createElementNS(
                        "http://www.w3.org/2000/svg",
                        "linearGradient"
                    ),
                    stop1 = document.createElementNS("http://www.w3.org/2000/svg", "stop"),
                    stop2 = document.createElementNS("http://www.w3.org/2000/svg", "stop"),
                    linearGradientBackground = document.createElementNS(
                        "http://www.w3.org/2000/svg",
                        "background"
                    );
                linearGradient.setAttribute("id", "gradient");
                stop1.setAttribute("stop-color", "#008451");
                stop1.setAttribute("offset", "0%");
                linearGradient.appendChild(stop1);
                stop2.setAttribute("stop-color", "#008451");
                stop2.setAttribute("offset", "100%");
                linearGradient.appendChild(stop2);
                linearGradientBackground.setAttribute("id", "gradient-background");
                var stop1 = document.createElementNS("http://www.w3.org/2000/svg", "stop");
                stop1.setAttribute("stop-color", "rgba(0,0,0,0.2)");
                stop1.setAttribute("offset", "0%");
                linearGradientBackground.appendChild(stop1);
                var stop2 = document.createElementNS("http://www.w3.org/2000/svg", "stop");
                stop2.setAttribute("stop-color", "rgba(0,0,0,0.5)");
                stop2.setAttribute("offset", "1000%");
                linearGradientBackground.appendChild(stop2);
                defs.appendChild(linearGradient);
                defs.appendChild(linearGradientBackground);
                this.svg.appendChild(defs);
                this.defs = defs;
            }

            createSlice() {
                let slice = document.createElementNS("http://www.w3.org/2000/svg", "path");
                slice.setAttribute("fill", "none");
                slice.setAttribute("stroke", "url(#gradient)");
                slice.setAttribute("stroke-width", this.strokeWidth);
                slice.setAttribute(
                    "transform",
                    `translate(${this.strokeWidth / 2},${this.strokeWidth / 2})`
                );
                slice.setAttribute("class", "animate-draw");
                this.svg.appendChild(slice);
                this.slice = slice;
            }

            createOverlay() {
                const r = this.size - this.size / 2 - this.strokeWidth / 2;
                const circle = document.createElementNS(
                    "http://www.w3.org/2000/svg",
                    "circle"
                );
                circle.setAttribute("cx", this.size / 2);
                circle.setAttribute("cy", this.size / 2);
                circle.setAttribute("r", r);
                circle.setAttribute("fill", "url(#gradient-background)");
                circle.setAttribute("class", "animate-draw");
                this.svg.appendChild(circle);
                this.overlay = circle;
            }
            createText() {
                const fontSize = this.size / 3.5;
                let text = document.createElementNS("http://www.w3.org/2000/svg", "text");
                text.setAttribute("x", this.size / 2 );
                text.setAttribute("y", this.size / 2 - fontSize / 4 );
                text.setAttribute("font-size", fontSize);
                text.setAttribute("fill", "#008451");
                text.setAttribute("text-anchor", "middle");
                const tspanSize = fontSize / 3;
                text.innerHTML = `${0}`;
                this.svg.appendChild(text);
                this.text = text;
            }
            animateStart() {
                let v = 0;
                const intervalOne = setInterval(() => {
                    const p = +(v / this.value).toFixed(2);
                    const a = p < 0.95 ? 2 - 2 * p : 0.05;
                    v += a;
                    if (v >= +this.value) {
                        v = this.value;
                        clearInterval(intervalOne);
                    }
                    this.setValue(v);
                }, 30);
            }
            polarToCartesian(centerX, centerY, radius, angleInDegrees) {
                const angleInRadians = ((angleInDegrees - 180) * Math.PI) / 180.0;
                return {
                    x: centerX + radius * Math.cos(angleInRadians),
                    y: centerY + radius * Math.sin(angleInRadians)
                };
            }
            describeArc(x, y, radius, startAngle, endAngle) {
                const start = this.polarToCartesian(x, y, radius, endAngle);
                const end = this.polarToCartesian(x, y, radius, startAngle);
                const largeArcFlag = endAngle - startAngle <= 180 ? "0" : "1";
                const d = [
                    "M",
                    start.x,
                    start.y,
                    "A",
                    radius,
                    radius,
                    0,
                    largeArcFlag,
                    0,
                    end.x,
                    end.y
                ].join(" ");
                return d;
            }

            setValue(value) {
                let c = (value / 100) * 360;
                if (c === 360) c = 359.99;
                const xy = this.size / 2 - this.strokeWidth / 2;
                const d = this.describeArc(xy, xy, xy, 90, 90 + c);
                this.slice.setAttribute("d", d);
                const tspanSize = this.size / 3.5 / 3;
                {{--let numberOfPoints=document.createElement('span');--}}
                {{--numberOfPoints.classList.add("number-of-points");--}}
                {{--numberOfPoints.textContent="{{__('point')}}";--}}
                this.text.innerHTML = `${Math.floor(value)}`;

            }

            animateReset() {
                this.setValue(0);
            }
        }

        const containersProgress = document.getElementsByClassName("chart");
        const dial = new Dial(containersProgress[0]);
        pointSection =  document.querySelector(".btn-points");
        pointSection.addEventListener("click",()=>{
            dial.animateStart();
        })




    </script>

@endsection
