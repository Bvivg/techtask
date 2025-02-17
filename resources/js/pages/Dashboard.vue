<template>
  <div class="container mt-4">
    <h2>Проверка доступности доменов</h2>

    <form @submit="checkDomains">
      <div class="mb-3">
        <label for="domains" class="form-label">Введите домены</label>
        <textarea id="domains" class="form-control" v-model="domainsStr" rows="5"
          placeholder="Введите домены через запятую или с новой строки"></textarea>
      </div>

      <button type="submit" class="btn btn-primary">Проверить</button>
    </form>

    <div v-if="loading" class="mt-3">
      <p>Загрузка...</p>
    </div>
    <div v-if="errorMessage.length" class="mt-3">
      <p>{{ errorMessage }}</p>
    </div>

    <div v-if="results" class="mt-3">
      <h3>Результаты:</h3>
      <ul class="list-group">
        <li v-for="(result, domain) in results" :key="domain" class="list-group-item">
          <strong>{{ domain }}:</strong> {{ result }}
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import Request from '../Request';

const results = ref<Record<string, string>>({});
const loading = ref(false);
const errorMessage = ref('');
const domainsStr = ref('');

const checkDomains = async (e: Event) => {
  e.preventDefault();

  if (!domainsStr.value.trim()) {
    
    errorMessage.value = 'форма не должна быть пустой';
    return;
  }
  const domainsArray = domainsStr.value.split(/\s*,\s*|\s+/).map(domain => domain.trim()).filter(domain => domain);
  const uniqueDomains = new Set(domainsArray);
  if (uniqueDomains.size !== domainsArray.length) {
    errorMessage.value = 'некоторые домены дублируются в отправленной форме';
    return;
  }

  loading.value = true;
  try {
    const response = await Request.post<Record<string, string>, any>('domains/check/whois', { domains: Array.from(uniqueDomains) });
    results.value = response;
  } catch (error) {
    console.error(error);
    errorMessage.value = 'произошла ошибка при проверке доменов';
  } finally {
    loading.value = false;
  }
};

</script>

<style scoped></style>
