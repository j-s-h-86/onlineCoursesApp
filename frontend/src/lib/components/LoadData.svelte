<script>
	import { onMount } from 'svelte';
	import { getCourses, getCourseById, getTeachers, getTeacherById, getOrders } from '$lib/api';
	import DisplayCourses from './DisplayCourses.svelte';

	let courses = [];
	let teachers = [];
	let orders = [];
	let error = null;

	// async function loadCourses() {
	// 	try {
	// 		courses = await getCourses();
	// 	} catch (error) {
	// 		console.error(error);
	// 	}
	// 	console.log(courses);
	// 	return { props: { courses } };
	// }

	// async function loadTeachers() {
	// 	try {
	// 		teachers = await getTeachers();
	// 	} catch (error) {
	// 		console.error(error);
	// 	}
	// 	console.log(teachers);
	// 	return { props: { teachers } };
	// }

	// async function loadOrders() {
	// 	try {
	// 		orders = await getOrders();
	// 	} catch (error) {
	// 		console.error(error);
	// 	}
	// 	console.log(orders);
	// }

	// onMount(() => {
	// 	loadCourses();
	// 	loadTeachers();
	// 	loadOrders();
	// });

	onMount(async () => {
		try {
			const coursesData = await getCourses(); // Fetch the courses
			// Map through the courses to rename or modify properties
			const mappedCourses = coursesData.map((course) => {
				return {
					id: course.id, // Keep the course ID
					name: course.courseName, // Map courseName to name
					description: course.courseDescription // Map courseDescription to description
				};
			});
			courses = mappedCourses; // Update the courses with mapped data
		} catch (err) {
			error = err.message; // Handle any errors that occur during fetch
		}
	});
</script>

{#if error}
	<p>Error: {error}</p>
{:else}
	<DisplayCourses {courses} /> <!-- Pass the mapped courses to DisplayCourses -->
{/if}
