# Schedule-Meeting-ZoneWise

Description: Create a tool that allows users to input multiple time zones and suggests optimal meeting times based on availability. Include a feature to sync with Google Calendar or export the schedule.

Tools: HTML, CSS, JavaScript (APIs for time zone and calendar integration), Python for data visualization , MySQL database
Unique Aspect: Focus on usability and solving a practical problem, which many remote workers face.  

1. Define the User Flow
	User Input: Users enter multiple time zones (e.g., their location and the locations of other meeting participants).
	Availability Input: Users can input their availability (e.g., working hours or preferred meeting times). 
	Meeting Suggestions: The app suggests optimal meeting times based on the inputted time zones and availability.
	Calendar Sync/Export: Users can sync the suggested meeting time with Google Calendar or export the schedule as an ICS file.

2. Wireframe the Layout
	Homepage:
		Header: Logo, navigation bar (Home, Time Zone Converter, Meeting Planner).
		Main Section: Time zone input fields and availability input form.
		Footer: Links to About, Contact, and social media.

	Meeting Planner Page:
		Sidebar: List of added time zones with options to edit or remove them.
		Main Section: Display of suggested meeting times based on inputted availability.
		Buttons: Options to sync with Google Calendar or export the schedule.

3. Design the User Interface (UI)
	Color Scheme: Use a professional and clean palette, like shades of blue and gray, to make the app visually appealing and easy to use.
	Typography: Clear and legible fonts, with larger sizes for input fields and buttons.
	Icons: Use intuitive icons for adding time zones, editing availability, and syncing/exporting schedules.
	Buttons and Forms: Design large, easily clickable buttons and well-spaced form inputs.

4. Implement Responsive Design
	Mobile Layout:
		Collapse sidebars into dropdown menus.
		Stack elements vertically to fit smaller screens.
		Increase the size of touch targets like buttons and form inputs.

	Tablet Layout:
		Maintain a sidebar but reduce its width.
		Ensure time zone selection and availability input are easy to interact with on touch screens.

	Desktop Layout:
		Use a grid layout to display time zone input, availability, and meeting suggestions side by side.

5. Focused on UX Principles
	Navigation: Kept it simple and predictable. Users should easily find where to input time zones and availability, and how to get meeting suggestions.
	Feedback: Provide real-time feedback when time zones are added or when meeting suggestions are generated.
	Accessibility: Ensure color contrast for readability, and provide alternative text for icons. Implement keyboard navigation.

6. Developed the Core Features
	Time Zone Input: Use a time zone API (like worldtimeapi.org or moment-time zone) to fetch and display time zones.
	Availability Input: Create a form where users can select their available hours for each day of the week.
	Meeting Suggestions: Write a JavaScript algorithm to calculate overlapping available times across all inputted time zones and display the optimal meeting times.
	Calendar Sync/Export: Use the Google Calendar API for syncing or create an export function that generates an ".ics" file for users to import into their calendars.

7. Added Interactive Animations
	Transitions: Smooth transitions when adding/removing time zones and generating meeting suggestions.
	Hover Effects: Subtle hover effects on buttons and input fields.
	Loading Indicators: Show loading spinners or progress bars when fetching time zone data or syncing with Google Calendar.

Here are some samples how ot looks:

![Screenshot (66)](https://github.com/user-attachments/assets/1851874e-8046-441b-8c9c-b71923fae400)
![Screenshot (67)](https://github.com/user-attachments/assets/167e20ca-6704-4e23-9db8-ec9e9bbd8d05)


