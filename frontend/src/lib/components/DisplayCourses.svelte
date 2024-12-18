<script>
	export let courses = [];
</script>

<h2>Kursutbud</h2>
{#if courses.length > 0}
	<div class="onlineCourses">
		{#each courses as course}
			<div class="course">
				<h3>{course.name}</h3>
				<p>{course.description}</p>
				<p>{course.teacherName}</p>
			</div>
		{/each}
	</div>
{:else}
	<p>Inga tillgängliga kurser just nu.</p>
{/if}

<style>
	.onlineCourses {
		width: 100%;
		height: 100vh;
		display: flex;
		justify-content: space-evenly;
	}

	.course {
		display: flex;
		flex-direction: column;
		justify-content: space-evenly;
		text-align: center;
		height: 300px;
		width: 250px;
		border: 1px solid black;
		border-radius: 10%;
	}
</style>
