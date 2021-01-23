
    <div class="col-12 border border-dark rounded-lg p-lg-4 mb-3">
        @if($data['birthday'] != '')
            <h2 class="pt-2">
                <i class="fas fa-birthday-cake"></i> {{ $data['birthday'] }}
            </h2>
        @endif
        <h2 class="pt-2 font-weight-bolder">
            {{$data['years']}} years, since {{$data['foundingYear']}}.
        </h2>
        <p>
            Founded on September 13, 1904,
            IATSE Local 118 (International Alliance of Theatrical Stage Employees of the United States
            and Canada) the labour union supplying technicians, stagehands, artisans and craftspeople to
            the Greater Vancouver entertainment industry, including live theatre, rock and roll, trade
            shows, and conventions. Local 118 has a large, skilled and experienced workforce ready to meet
            the needs of your production.
        </p>
        <p>
            <a class="btn btn-primary btn-lg" href="/page/history" role="button">
                Learn more &raquo;
            </a>
        </p>
    </div>

