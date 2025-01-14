<script>
	import PurchaseModal from './modals/purchaseModal.svelte';
	import { modalStates, courses } from '$lib/stores';

	let purchaseModal = false;
	let selectedCourse = null;
	let error = null;

	function openPurchaseModal(course) {
		selectedCourse = course;
		modalStates.update((state) => {
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
{#if $courses.length > 0}
	<div class="onlineCourses">
		{#each $courses as course}
			<div class="course">
				<h3>{course.name}</h3>
				<span><b>Kursbeskrivning:</b></span>
				<span>{course.description}</span>
				<p>Lärare: {course.teacherName}</p>
				<p>Antal tillfällen: {course.occasions}</p>
				<p>Pris: {course.price} SEK</p>
				<button class="purchaseButton" on:click={() => openPurchaseModal(course)}>Köp kurs</button>
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
	h2 {
		color: #ffb764;
	}

	.onlineCourses {
		width: 100%;
		display: flex;
		flex-wrap: wrap;
		justify-content: space-evenly;
		background-color: #3a424a;
	}

	.course {
		display: flex;
		flex-direction: column;
		align-items: center;
		text-align: center;
		height: 400px;
		width: 350px;
		border: 1px solid black;
		border-radius: 10%;
		margin: 20px;
		background-color: #595e61;
		padding: 10px;
	}

	.purchaseButton {
		width: 75px;
		height: 35px;
		background-color: #3a424a;
		color: #ffb764;
	}
</style>
