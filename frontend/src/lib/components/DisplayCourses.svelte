<script>
	export let courses = [];
</script>

<h2>Kursutbud</h2>
{#if courses.length > 0}
	<div class="onlineCourses">
		{#each courses as course}
			<div class="course">
				<h3>{course.name}</h3>
				<span><b>Kursbeskrivning:</b></span>
				<span>{course.description}</span>
				<p>Lärare: {course.teacherName}</p>
				<p>Antal tillfällen: {course.occasions}</p>
				<p>Pris: {course.price} SEK</p>
			</div>
		{/each}
	</div>
{:else}
	<p>Inga tillgängliga kurser just nu.</p>
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
