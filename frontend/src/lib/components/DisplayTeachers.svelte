<script>
	import { teachers } from '$lib/stores';
	import { onMount } from 'svelte';
	import { get } from 'svelte/store';

	let allTeachers = [];

	onMount(() => {
		const unsubscribe = teachers.subscribe((value) => {
			allTeachers = value;
		});

		return () => {
			unsubscribe();
		};
	});
</script>

<h2>Våra coacher</h2>
{#if allTeachers.length > 0}
	<div class="onlineCoaches">
		{#each allTeachers as teacher}
			<div class="coach">
				<h3>{teacher.name}</h3>
				<div class="teacherImgContainer">
					<img src={teacher.img} alt="coach" />
				</div>
				<div>
					<p><b>Information:</b></p>
					<p>{teacher.description}</p>
				</div>
			</div>
		{/each}
	</div>
{:else}
	<p>Inga coacher anställda just nu.</p>
{/if}

<style>
	.onlineCoaches {
		width: 100%;
		display: flex;
		flex-wrap: wrap;
		justify-content: space-evenly;
	}

	.coach {
		display: flex;
		flex-direction: column;
		justify-content: space-evenly;
		text-align: center;
		height: 400px;
		width: 350px;
		border: 1px solid black;
		border-radius: 10%;
	}

	.teacherImgContainer {
		height: 200px;
		width: auto;
	}

	img {
		height: 100%;
		width: auto;
	}
</style>
