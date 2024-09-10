<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>World Time Clock</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="clock-container">
    <h1 style="color: #fff">World Time Clock</h1>
    
    <div class="selection">
      <label for="location" style="color: #fff">Select a Location:</label>
      <select id="location" name="location">
        <option value="">--Choose a Location--</option>
        <option value="America/Chicago">Chicago (CST)</option>
        <option value="America/Denver">Denver (MST)</option>
        <option value="Asia/Hong_Kong">Hong Kong (HKT)</option>
        <option value="Asia/Calcutta">Kolkata (IST)</option>
        <option value="Europe/London">London (GMT)</option>
        <option value="America/Los_Angeles">Los Angeles (PST)</option>
        <option value="America/New_York">New York (EST)</option>
        <option value="Asia/Singapore">Singapore (SGT)</option>
        <option value="Australia/Sydney">Sydney (AEDT)</option>
        <option value="Asia/Tokyo">Tokyo (JST)</option>
      </select>
    </div>

    <!-- Circular clock -->
    <div class="container">
        <div class="clock">
            <div class="circle" id="sc" style="--clr: #04fc43;"><i></i></div>
            <div class="circle circle2" id="mn" style="--clr: #fee800;"><i></i></div>
            <div class="circle circle3" id="hr" style="--clr: #ff2972;"><i></i></div>

            <span style="--i:1;"><b>1</b></span>
            <span style="--i:2;"><b>2</b></span>
            <span style="--i:3;"><b>3</b></span>
            <span style="--i:4;"><b>4</b></span>
            <span style="--i:5;"><b>5</b></span>
            <span style="--i:6;"><b>6</b></span>
            <span style="--i:7;"><b>7</b></span>
            <span style="--i:8;"><b>8</b></span>
            <span style="--i:9;"><b>9</b></span>
            <span style="--i:10;"><b>10</b></span>
            <span style="--i:11;"><b>11</b></span>
            <span style="--i:12;"><b>12</b></span>
        </div>
        <!-- Digital clock -->
        <div id="time">
            <div id="hs" style="--clr: #ff2972;">00</div>
            <div id="ms" style="--clr: #fee800;">00</div>
            <div id="cs" style="--clr: #04fc43;">00</div>
            <div id="apm">AM</div>
        </div>
    </div>
    
  <script src="app.js"></script>
</body>
</html>
