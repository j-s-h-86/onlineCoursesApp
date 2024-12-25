<script>
	import PurchaseModal from './modals/purchaseModal.svelte';
	import { modalStates, courses } from '$lib/stores';
	import { onMount } from 'svelte';
	import { get } from 'svelte/store';
	import { postOrder } from '$lib/api';

	let allCourses = [];
	let purchaseModal = false;
	let selectedCourse = null;

	onMount(() => {
		const unsubscribe = courses.subscribe((value) => {
			allCourses = value;
		});

		return () => {
			unsubscribe();
		};
	});

	function openPurchaseModal(course) {
		selectedCourse = course;
		console.log('Opening modal for course:', course);
		modalStates.update((state) => {
			console.log('Updating modal state to true');
			return { ...state, purchaseModal: true };
		});
	}

	modalStates.subscribe((state) => {
		if (!state.purchaseModal) {
			selectedCourse = null;
		}
	});
</script>

<h2>Kursutbud</h2>
{#if allCourses.length > 0}
	<div class="onlineCourses">
		{#each allCourses as course}
			<div class="course">
				<h3>{course.name}</h3>
				<span><b>Kursbeskrivning:</b></span>
				<span>{course.description}</span>
				<p>Lärare: {course.teacherName}</p>
				<p>Antal tillfällen: {course.occasions}</p>
				<p>Pris: {course.price} SEK</p>
				<button on:click={() => openPurchaseModal(course)}>Köp kurs</button>
			</div>
		{/each}
	</div>
{:else}
	<p>Inga tillgängliga kurser just nu.</p>
{/if}

{#if selectedCourse}
	<PurchaseModal {selectedCourse} />
{/if}

<style>
	.onlineCourses {
		width: 100%;
		display: flex;
		flex-wrap: wrap;
		justify-content: space-evenly;
	}

	.course {
		display: flex;
		flex-direction: column;
		text-align: center;
		height: 400px;
		width: 350px;
		border: 1px solid black;
		border-radius: 10%;
	}
</style>
