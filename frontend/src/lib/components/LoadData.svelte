<script>
	import { onMount } from 'svelte';
	import { getCourses, getCourseById, getTeachers, getTeacherById, getOrders } from '$lib/api';

	let courses = [];
	let teachers = [];
	let orders = [];

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

	async function loadOrders() {
		try {
			orders = await getOrders();
		} catch (error) {
			console.error(error);
		}
		console.log(orders);
	}

	onMount(() => {
		loadCourses();
		loadTeachers();
		loadOrders();
	});
</script>
