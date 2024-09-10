let timePairs = [];
document.getElementById('suggest-meeting').addEventListener('click', function(event) {
    event.preventDefault();  // Prevent the default form submission

    fetch('availabile_meeting_times.php') 
        .then(response => response.json())
        .then(data => {
            const meetingList = document.getElementById('meeting-list');
            meetingList.innerHTML = '';
            timePairs = [];

            data.forEach(meeting => {
                const li = document.createElement('li');
                li.textContent = `${meeting.Name}, ${meeting.emp_id} from zone ${meeting.Zone} meeting on ${meeting.Start_time} to ${meeting.End_time}`;
                meetingList.appendChild(li);
                timePairs.push([meeting.Start_time, meeting.End_time]);
            });

            // console.log(typeof(timePairs[0][0]));
            console.log(typeof(timePairs));
            console.log(timePairs);
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
});


// --------------------------our-analysis----------------------

document.getElementById('our-analysis').addEventListener('click', function(event) {
    event.preventDefault();

    fetch('PhpWithPy.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ timePairs: timePairs })
    })
    .then(response => response.json())
    .then(result => {
        const resultContainer = document.getElementById('analysis-results');
        resultContainer.innerHTML = '';
        const section = document.createElement('section');
        section.innerHTML = '<h4>Available Time Intervals</h4>';

        if (Array.isArray(result)) {
            result.forEach(intervals => {
                
                const ul = document.createElement('ul');
                const li = document.createElement('li');
                li.textContent = `${intervals[0]} - ${intervals[1]}`;
                ul.appendChild(li);

                section.appendChild(ul);
                resultContainer.appendChild(section);
            });
        } else {
            resultContainer.innerHTML = '<p>Unexpected response format.</p>';
        }
    })
    .catch(error => {
        console.error('Error:', error); 
    });
});