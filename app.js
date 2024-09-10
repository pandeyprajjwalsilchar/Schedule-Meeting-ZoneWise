//----------------------------------------------------START :JS----------------------------------
const locationSelect = document.getElementById('location');
const hourHand = document.querySelector('.hour-hand');
const minuteHand = document.querySelector('.minute-hand');
const secondHand = document.querySelector('.second-hand');
// const loadingMessage = document.getElementById('loading-message');


let clockInterval;

function updateClock(currentDateTime) {
    const hr = document.getElementById('hr');
    const mn = document.getElementById('mn');
    const sc = document.getElementById('sc');

    const day = currentDateTime;
    const hh = day.getHours() * 30;
    const mm = day.getMinutes() * 6;
    const ss = day.getSeconds() * 6;

    hr.style.transform = `rotateZ(${hh + (mm / 12)}deg)`;
    mn.style.transform = `rotateZ(${mm}deg)`;
    sc.style.transform = `rotateZ(${ss}deg)`;

    const hs = document.getElementById('hs');
    const ms = document.getElementById('ms');
    const cs = document.getElementById('cs');
    const apm = document.getElementById('apm');

    let h = currentDateTime.getHours();
    let m = currentDateTime.getMinutes();
    let s = currentDateTime.getSeconds();

    const am = (h >= 12) ? "PM" : "AM";

    if (h > 12) {
        h = h - 12;
    }

    h = (h < 10) ? "0" + h : h;
    m = (m < 10) ? "0" + m : m;
    s = (s < 10) ? "0" + s : s;

    hs.innerHTML = h;
    ms.innerHTML = m;
    cs.innerHTML = s;
    apm.innerHTML = am;
}

async function fetchTime(location) {
  try {

    // loadingMessage.style.display = 'block';

    const response = await fetch(`http://worldtimeapi.org/api/timezone/${location}`);
    const data = await response.json();

    // loadingMessage.style.display = none;

    console.log(data);
    const p = data.datetime;
    const q = p.split('T')[1].split('+')[0].split('.')[0];

    const timeString = q;

    const currentDate = new Date();

    const [hours, minutes, seconds] = timeString.split(':').map(Number);

    currentDate.setHours(hours, minutes, seconds, 0);

    if (clockInterval) {
      clearInterval(clockInterval);
    }

    updateClock(currentDate);

    clockInterval = setInterval(() => {
      currentDate.setSeconds(currentDate.getSeconds() + 1);
      updateClock(currentDate);
    }, 1000);
  } catch (error) {
    console.error('Error fetching time:', error);
  }
}

locationSelect.addEventListener('change', () => {
  const selectedLocation = locationSelect.value;
  if (selectedLocation) {
    fetchTime(selectedLocation);
  }
});


window.onload = async () => {
    const userTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;
    locationSelect.value = userTimeZone;  
    await fetchTime(userTimeZone); 
};