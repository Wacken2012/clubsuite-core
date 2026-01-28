<template>
  <div class="pagination">
    <button @click="$emit('prev')">Prev</button>
    <slot></slot>
    <button @click="$emit('next')">Next</button>
  </div>
</template>

<script>
export default { name: 'Pagination' }
</script>
