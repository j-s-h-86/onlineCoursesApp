<script>
	import Header from '$lib/components/layout/Header.svelte';
	import Footer from '$lib/components/layout/Footer.svelte';
	import { onMount } from 'svelte';
	import { courses, teachers } from '$lib/stores';
	import { getCourses, getTeachers } from '$lib/api';

	onMount(async () => {
		try {
			console.log('Fetching courses and teachers...');
			await Promise.all([getCourses(), getTeachers()]);
			console.log('Data fetched successfully!');
		} catch (error) {
			console.error('Error fetching data:', error);
		}
	});
</script>

<Header />
<main>
	<div class="appWrap">
		<slot />
	</div>
</main>
<Footer />

<style>
	.appWrap {
		text-align: center;
		width: 100%;
		padding: 20px;
	}
	main {
		background-color: #3a424a;
		padding: 10px;
		min-height: 100%;
	}
</style>
