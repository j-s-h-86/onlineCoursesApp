<script>
	export let courses = [];
</script>

<h2>Courses</h2>
{#if courses.length > 0}
	<ul>
		{#each courses as course}
			<li>
				<h3>{course.name}</h3>
				<p>{course.description}</p>
			</li>
		{/each}
	</ul>
{:else}
	<p>No courses available.</p>
{/if}
