<!DOCTYPE html>
<html>
<head>
    <title>CV</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 32px;
            text-align: center;
        }
        .about {
            margin-top: 10px;
            font-size: 16px;
            text-align: justify;
            width: 100%;
            max-width: 600px;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .location {
            text-align: center;
            margin: 0;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }
        ul li {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>{{ $freelancer->first_name }} {{ $freelancer->last_name }}</h1>
        <p class="location">{{ $freelancer->location }}</p>
        <div class="about">
            <p>{{ $freelancer->about }}</p>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Skills</div>
        <ul>
            @foreach ($skills as $skill)
                <li>{{ $skill->name }}</li>
            @endforeach
        </ul>
    </div>

    <div class="section">
        <div class="section-title">Experience</div>
        <ul>
            @foreach ($experiences as $experience)
                <li>{{ $experience->company_name }} -  {{ $experience->employment_type }} ({{ $experience->start_date }} - {{ $experience->end_date }}) </li>
                <p>{{ $experience->description }}</p>
            @endforeach
        </ul>
    </div>

    <div class="section">
        <div class="section-title">Projects</div>
        <ul>
            @foreach ($portfolios as $portfolio)
                <li>{{ $portfolio->title }} - <a href="{{ $portfolio->link }}">{{ $portfolio->link }}</a></li>
                <p>{{ $portfolio->description }}</p>
            @endforeach
        </ul>
    </div>

    <div class="section">
        <div class="section-title">Education</div>
        <ul>
            @foreach ($educations as $education)
                <li>{{ $education->institution }} - {{ $education->title }} ({{ $education->start_year }} - {{ $education->end_year }})</li>
                <p>{{ $education->description }}</p>
            @endforeach
        </ul>
    </div>

    <div class="section">
        <div class="section-title">Certifications</div>
        <ul>
            @foreach ($certifications as $certification)
                <li>{{ $certification->title }} -  <a href="{{ $certification->link }}">{{ $certification->link }}</a> ({{ $certification->start_date }} - {{ $certification->end_date }})</li>
            @endforeach
        </ul>
    </div>
</div>
</body>
</html>
