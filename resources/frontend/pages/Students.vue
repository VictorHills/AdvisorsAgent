<template>
  <div>
    <h1 style="font-size:22px; margin-bottom:12px;">Students</h1>
    <div v-if="loading">Loading students...</div>
    <div v-else>
      <ul>
        <li v-for="s in students" :key="s.id" style="margin-bottom:8px; padding:8px; border:1px solid #e5e7eb; border-radius:6px;">
          <div style="font-weight:600;">{{ s.name }}</div>
          <div style="font-size:13px; color:#6b7280;">{{ s.email }}</div>
        </li>
      </ul>
      <div v-if="students.length === 0" style="color:#6b7280; margin-top:12px;">No students found (example data).</div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
const students = ref([]);
const loading = ref(true);

onMounted(async () => {
  try {
    const res = await axios.get('/students');
    students.value = res.data;
  } catch (e) {
    students.value = [
      { id: 1, name: 'Jane Doe', email: 'jane@example.com' },
      { id: 2, name: 'John Smith', email: 'john@example.com' },
    ];
  } finally {
    loading.value = false;
  }
});
</script>
