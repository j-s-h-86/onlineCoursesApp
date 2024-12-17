<script>
	import { onMount } from 'svelte';
	import { getCourses, getCourseById, getTeachers, getTeacherById } from '$lib/api';

	let courses = [];
	let teachers = [];

	async function loadCourses() {
		try {
			courses = await getCourses();
		} catch (error) {
			console.error(error);
		}
		console.log(courses);
	}

	async function loadTeachers() {
		try {
			teachers = await getTeachers();
		} catch (error) {
			console.error(error);
		}
		console.log(teachers);
	}

	onMount(() => {
		loadCourses();
		loadTeachers();
	});
</script>
