<script>
	import { onMount } from 'svelte';
	import { getCourses, getTeachers } from '$lib/api';
	import DisplayCourses from './DisplayCourses.svelte';

	let courses = [];
	let teachers = [];
	let orders = [];
	let error = null;

	onMount(async () => {
		try {
			const teachersData = await getTeachers();
			console.log('Teachers Data:', teachersData);

			const mappedTeachers = teachersData.map((teacher) => {
				return {
					id: teacher.id,
					name: teacher.teacherName,
					email: teacher.teacherEmail
				};
			});

			const teacherMap = mappedTeachers.reduce((map, teacher) => {
				map[teacher.id] = teacher.name;
				return map;
			}, {});

			const coursesData = await getCourses();
			console.log('Courses Data:', coursesData);

			const mappedCourses = coursesData.map((course) => {
				return {
					id: course.id,
					name: course.courseName,
					description: course.courseDescription,
					teacherName: teacherMap[course.teacherId] || 'Unknown',
					occasions: course.occasions,
					price: course.price
				};
			});

			courses = mappedCourses;
			teachers = mappedTeachers;
		} catch (err) {
			error = err.message;
		}
	});
</script>

{#if error}
	<p>Error: {error}</p>
{:else}
	<DisplayCourses {courses} />
{/if}
