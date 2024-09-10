import json
from datetime import datetime, timedelta

class Solution:
    def suggestMeetingTimes(self, intervals):
        # times = [["10:00", "12:00"], ["11:30", "13:30"], ["12:00", "14:00"], ["12:30", "15:00"], ["11:00", "12:30"], ["13:00", "15:00"]]
    # times = [["09:00", "12:00"], ["10:30", "13:30"], ["11:00", "14:00"], ["11:30", "12:30"], ["12:00", "15:00"], ["12:30", "14:30"], ["13:00", "16:00"], ["14:00", "17:00"]]
    # times = [["11:00:00","20:20:00"],["10:30:00","20:30:00"],["10:00:00","15:00:00"],["11:00:00","15:00:00"],["22:00:00","02:30:00"],["17:00:00","21:00:00"],["22:00:00","12:00:00"],["13:00:00","16:00:00"],["14:00:00","15:00:00"],["11:00:00","01:00:00"],["02:00:00","04:00:00"]]
        mp = {}
        for item in intervals:
            if item[0] not in mp:
                mp[item[0]] = +1
            else:
                mp[item[0]] += 1

            if item[1] not in mp:
                mp[item[1]] = -1
            else:
                mp[item[1]] -= 1

        mp = dict(sorted(mp.items()))
        vals = list(mp.values())

        for i in range(1, len(vals)):
            vals[i] += vals[i-1]

        for key, val in mp.items():
            mp[key] = vals[list(mp.keys()).index(key)]

        ks = list(mp.keys())
        max_value = max(vals)
        ind_of_max = [i for i in range(len(vals)) if vals[i] == max_value]

        start_times = [key for key, value in mp.items() if value == max_value]

        ls = []
        start_end_time = []

        # print(max_value)
        # print(ind_of_max)
        # print(ks)
        # print(vals)
        # print(start_times)

        for item in ind_of_max:
            j = item
            ls.append(ks[j])
            while vals[j] == max_value:
                ind_of_max.remove(j)
                j+=1
            ls.append(ks[j])
            start_end_time.append(ls)
            ls = []

        # print(start_end_time)
        return start_end_time

# Read the input data from the file
try:
    with open('data.json', 'r') as file:
        data = json.load(file)
        # print("Data read from file:", data)

except Exception as e:
    print(json.dumps({'error': str(e)}))
    exit()

# print(data['timePairs'])
optimal_times = []
if 'timePairs' not in data:
    print(json.dumps({'error': "'timePairs' key is missing in the data"}))
    exit()
else:
    try:
        optimal_times = Solution().suggestMeetingTimes(data['timePairs'])
        # print(json.dumps(optimal_times))
    except ValueError as ve:
        print(json.dumps({'error': str(ve)}))
        
#-----------------------------------PLOT CHART----------------------------------------------------

import numpy as np
import plotly
import plotly.graph_objects as go
from datetime import datetime
import json


times = data['timePairs']

mp = {i: 0 for i in range(0, 1440, 30)}

# Populate the dictionary based on the time intervals
for item in times:
    start = item[0]
    end = item[1]
    start_hour = int(start[0:2])
    start_min = int(start[3:5])
    end_hour = int(end[0:2])
    end_min = int(end[3:5])

    start_av = start_hour * 60 + start_min
    end_av = end_hour * 60 + end_min

    # Handle regular intervals
    if start_av < end_av:
        while start_av < end_av:
            mp[start_av] += 1
            start_av += 30
    # Handle intervals that cross midnight
    else:
        while start_av < 1440:
            mp[start_av] += 1
            start_av += 30
        start_av = 0
        while start_av < end_av:
            mp[start_av] += 1
            start_av += 30

# Convert the dictionary to an array for plotting
time_points = list(mp.keys())
participant_counts = list(mp.values())

# Convert minutes to hours for better readability
labels = [f'{i//60:02d}:{i%60:02d}' for i in time_points]

# Create the base circular heatmap in Plotly
n_intervals = len(time_points)
theta = np.linspace(0, 360, n_intervals, endpoint=False)  # Angles in degrees for circular plot

# Set up the plot
fig = go.Figure()

# Add barpolar trace for circular heatmap
fig.add_trace(go.Barpolar(
    r=[30] * n_intervals,  # Set equal radial thickness for all slices
    theta=theta,  # Position of the slice (in degrees)
    width=[360 / n_intervals] * n_intervals,  # Width of each slice (30 minutes each)
    marker=dict(
        color=participant_counts,  # Color based on the number of participants
        colorscale='RdYlGn',  # Color scheme for heatmap effect
        # colorscale=[[0, 'yellow'], [1, 'red']],
        cmin=min(participant_counts),
        cmax=max(participant_counts),  # Scale color to max participants
        showscale=True,  # Show color scale bar
        colorbar=dict(
            title="Participants",  # Title for the color bar
            len=0.6  # Adjust colorbar length
        )
    ),
    hoverinfo='text',  # Show hover information
    text=[f'Between {labels[i]} and {labels[(i+1) % n_intervals]} - Participants: {count}' 
          for i, count in enumerate(participant_counts)]  # Display intervals and participant count
))

# Update layout for better visualization
fig.update_layout(
    title="Circular Heatmap for Meeting Time Intervals",
    polar=dict(
        radialaxis=dict(showticklabels=False, ticks=''),  # Hide radial axis ticks
        angularaxis=dict(
            tickvals=theta,  # Ensure tick alignment with radial lines
            ticktext=labels,  # Use time labels (hh:mm) for each tick
            ticks='inside',  # Align ticks with radial lines
            ticklen=10,  # Length of ticks for better visibility
            direction="clockwise",  # Rotate clockwise like a clock
            rotation=90 # Start at the top (12:00)
        ),
    ),
    showlegend=False,
    height=700,
    width=700
)

# Export the figure to JSON
# plot_json = json.dumps(fig, cls=plotly.utils.PlotlyJSONEncoder)

# Save JSON to a file or send it via HTTP (depending on your setup)
# with open('plot.json', 'w') as f:
#     f.write(plot_json)


output = {
    'optimal_times': optimal_times,
    'plot_data': json.loads(fig.to_json())
}

print(json.dumps(output))
