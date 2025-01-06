<script>
	import { onMount } from 'svelte';
	import { get } from 'svelte/store';
	import { courses } from '$lib/stores';
	import { getCourses } from '$lib/api';
	export let url;

	let fullName = '';
	let email = '';
	let selectedCourseId = '';
	let price = '';

	onMount(async () => {
		await getCourses(url);
		const $courses = get(courses);
		if ($courses.length > 0) {
			selectedCourseId = $courses[0].id;
		}
	});

	async function addNewOrder() {
		const orderData = {
			fullName,
			email,
			courseId: parseInt(selectedCourseId),
			price: parseFloat(price)
		};

		try {
			const response = await fetch(url, {
				method: 'POST',
				headers: { 'Content-Type': 'application/json' },
				body: JSON.stringify(orderData)
			});
			const result = await response.json();
			alert(result.message || 'Order added successfully!');
		} catch (error) {
			console.error('Error submitting order:', error);
		}
	}
</script>

<form on:submit|preventDefault={addNewOrder}>
	<div>
		<label for="fullName">Namn:</label>
		<input type="text" id="fullName" bind:value={fullName} required />
	</div>

	<div>
		<label for="email">Epost:</label>
		<input type="email" id="email" bind:value={email} required />
	</div>

	<div>
		<label for="courseId">Välj en kurs:</label>
		<select id="courseId" bind:value={selectedCourseId}>
			<option value="" disabled>Välj en kurs...</option>
			{#each $courses as course}
				<option value={course.id}>{course.courseName}</option>
			{/each}
		</select>
	</div>

	<div>
		<label for="price">Pris:</label>
		<input type="number" id="price" step="0.01" bind:value={price} required />
	</div>

	<button type="submit">Lägg order</button>
</form>
