<script>
    import { onMount } from 'svelte';
    import { getCourses, getCourseById, getTeachers, getTeacherById } from '$lib/api';
  
    let courses = [];
    let course = null;
    let teachers = [];
    let teacher = null;
    let courseId = 1; // Exempelvärde
    let teacherId = 1; // Exempelvärde
  
    async function loadCourses() {
      try {
        courses = await getCourses();
      } catch (error) {
        console.error(error);
      }
    }
  
    async function loadCourseById(id) {
      try {
        course = await getCourseById(id);
      } catch (error) {
        console.error(error);
      }
    }
  
    async function loadTeachers() {
      try {
        teachers = await getTeachers();
      } catch (error) {
        console.error(error);
      }
    }
  
    async function loadTeacherById(id) {
      try {
        teacher = await getTeacherById(id);
      } catch (error) {
        console.error(error);
      }
    }
  
    onMount(() => {
      loadCourses();
      loadCourseById(courseId);
      loadTeachers();
      loadTeacherById(teacherId);
    });
  </script>
  
  <template>
    <h1>Courses</h1>
    <ul>
      {#each courses as course}
        <li>{course.name}</li>
      {/each}
    </ul>
  
    <h1>Course Details</h1>
    {#if course}
      <p>Name: {course.name}</p>
      <p>Description: {course.description}</p>
    {/if}
  
    <h1>Teachers</h1>
    <ul>
      {#each teachers as teacher}
        <li>{teacher.name}</li>
      {/each}
    </ul>
  
    <h1>Teacher Details</h1>
    {#if teacher}
      <p>Name: {teacher.name}</p>
      <p>Subject: {teacher.subject}</p>
    {/if}
  </template>
  