<template>
  <div class="member-detail-container">
    <div class="detail-toolbar">
      <button @click="$emit('back')" class="button">
        &larr; Zurück zur Liste
      </button>
      <button @click="$emit('edit', member)" class="button primary" v-if="member.user_id">
        Mitglied bearbeiten
      </button>
      <h2>Mitgliedsdetails</h2>
    </div>

    <div v-if="loading" class="loading">Laden...</div>
    <div v-else-if="error" class="error">{{ error }}</div>
    <div v-else class="member-info">
      
      <!-- Stammdaten -->
      <div class="section">
        <h3>Stammdaten</h3>
        <div class="field-grid">
          <div class="field">
            <label>Vorname</label>
            <div>{{ member.firstname || '-' }}</div>
          </div>
          <div class="field">
            <label>Nachname</label>
            <div>{{ member.lastname || '-' }}</div>
          </div>
          <div class="field">
            <label>E-Mail</label>
            <div>{{ member.email || '-' }}</div>
          </div>
          <div class="field">
            <label>Telefon</label>
            <div>{{ member.phone || '-' }}</div>
          </div>
        </div>
      </div>

      <!-- Adresse -->
      <div class="section">
        <h3>Adresse</h3>
        <div class="field-grid">
          <div class="field">
            <label>Straße</label>
            <div>{{ member.street || '-' }}</div>
          </div>
          <div class="field">
            <label>PLZ</label>
            <div>{{ member.zip || '-' }}</div>
          </div>
          <div class="field">
            <label>Ort</label>
            <div>{{ member.city || '-' }}</div>
          </div>
        </div>
      </div>

      <!-- Vereinsdaten -->
      <div class="section">
        <h3>Vereinsdaten</h3>
        <div class="field-grid">
          <div class="field">
            <label>Mitgliedsnummer</label>
            <div>{{ member.mitgliedsnummer || '-' }}</div>
          </div>
          <div class="field">
            <label>Eintrittsdatum</label>
            <div>{{ formatDate(member.eintrittsdatum) }}</div>
          </div>
          <div class="field">
            <label>Status</label>
            <div>{{ member.status || 'unknown' }}</div>
          </div>
        </div>
      </div>

      <!-- Verknüpfungen -->
      <div class="section links-section">
        <h3>Verknüpfungen</h3>
        
        <div class="link-group">
          <h4>Letzte Buchungen (Finance)</h4>
          <div v-if="transactions.length > 0">
              <table class="transaction-list">
                  <thead>
                      <tr>
                          <th>Datum</th>
                          <th>Beschreibung</th>
                          <th>Betrag</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr v-for="t in transactions" :key="t.id">
                          <td>{{ formatDate(t.date) }}</td>
                          <td>{{ t.description }}</td>
                          <td :class="t.type === 'income' ? 'amount-pos' : 'amount-neg'">
                              {{ parseFloat(t.amount).toFixed(2) }} €
                          </td>
                      </tr>
                  </tbody>
              </table>
          </div>
          <p v-else class="placeholder">Keine Buchungen gefunden.</p>
        </div>

        <div class="link-group">
          <h4>Letzte Spenden (Donations)</h4>
          <div v-if="donations.length > 0">
              <table class="transaction-list">
                  <thead>
                      <tr>
                          <th>Datum</th>
                          <th>Betrag</th>
                          <!--th>Zweck</th-->
                      </tr>
                  </thead>
                  <tbody>
                      <tr v-for="d in donations" :key="d.id">
                          <td>{{ formatDate(d.date) }}</td>
                          <td class="amount-pos">{{ parseFloat(d.amount).toFixed(2) }} €</td>
                          <!--td>{{ d.purpose || '-' }}</td-->
                      </tr>
                  </tbody>
              </table>
          </div>
          <p v-else class="placeholder">Keine Spenden gefunden.</p>
        </div>

        <div class="link-group">
          <h4>Trainingshistorie (Training)</h4>
          <div v-if="trainings.length > 0">
              <table class="transaction-list">
                  <thead>
                      <tr>
                          <th>Datum</th>
                          <th>Zeit</th>
                          <!--th>Ort</th-->
                          <th>Status</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr v-for="t in trainings" :key="t.id">
                          <td>{{ formatDate(t.date) }}</td>
                          <td>{{ t.start_time.substring(0,5) }}</td>
                          <!--td>{{ t.location || '-' }}</td-->
                          <td>{{ t.status }}</td>
                      </tr>
                  </tbody>
              </table>
          </div>
          <p v-else class="placeholder">Keine Trainingsdaten verfügbar</p>
        </div>

        <div class="link-group">
          <h4>Dokumente (Documents)</h4>
          <p class="placeholder">Keine Dokumente</p>
        </div>
      </div>
          
    </div>
  </div>
</template>

<script>
import axios from '@nextcloud/axios'
import { generateUrl } from '@nextcloud/router'

export default {
  name: 'MemberDetail',
  props: {
    id: {
      type: String,
      required: true
    }
  },
  data() {
    return {
      loading: true,
      error: null,
      member: {},
      transactions: [],
      donations: [],
      trainings: []
    }
  },
  mounted() {
    this.fetchData()
    this.fetchTransactions()
    this.fetchDonations()
    this.fetchTrainings()
  },
  methods: {
    async fetchTrainings() {
        try {
            const url = generateUrl('/apps/clubsuite-training/attendance')
            const response = await axios.get(url, {
                params: { user_id: this.id }
            })
            // API returns array directly
            this.trainings = Array.isArray(response.data) ? response.data : []
        } catch (e) {
            console.warn("Training app info could not be loaded", e)
            this.trainings = [] 
        }
    },
    async fetchDonations() {
        try {
            // Check if clubsuite-donations app is installed/active via endpoints or try-catch
            const url = generateUrl('/apps/clubsuite-donations/donations')
            const response = await axios.get(url, {
                params: {
                    user_id: this.id,
                    sort: 'date',
                    order: 'desc',
                    limit: 5
                }
            })
            // The API returns { rows: [...], total: ... }
            this.donations = response.data.rows || []
        } catch (e) {
            console.warn("Donations app info could not be loaded", e)
            this.donations = [] 
        }
    },
    async fetchTransactions() {
        try {
            const url = generateUrl('/apps/clubsuite-finance/transactions')
            const response = await axios.get(url, {
                params: {
                    member_id: this.id,
                    sort: 'date',
                    order: 'desc',
                    limit: 5
                }
            })
            // The API returns { rows: [...], total: ... }
            this.transactions = response.data.rows || []
        } catch (e) {
            console.warn("Finance app info could not be loaded", e)
            this.transactions = [] 
        }
    },
    async fetchData() {
      this.loading = true
      this.error = null
      try {
        // Using the API route: /members/{id}
        const response = await axios.get(generateUrl('/apps/clubsuite-core/members/' + this.id))
        this.member = response.data
      } catch (e) {
        console.error(e)
        this.error = 'Fehler beim Laden der Mitgliedsdaten.'
      } finally {
        this.loading = false
      }
    },
    formatDate(dateStr) {
      if (!dateStr) return '-'
      // Assuming dateStr matches standard ISO or DB format, mostly YYYY-MM-DD
      const date = new Date(dateStr)
      if (isNaN(date)) return dateStr
      return date.toLocaleDateString('de-DE')
    }
  }
}
</script>

<style scoped>
.member-detail-container {
  padding: 20px;
}
.detail-toolbar {
  display: flex;
  align-items: center;
  gap: 20px;
  margin-bottom: 20px;
}
.section {
  background: var(--color-main-background);
  border: 1px solid var(--color-border);
  border-radius: var(--border-radius-large);
  padding: 20px;
  margin-bottom: 20px;
}
.section h3 {
  margin-top: 0;
  border-bottom: 1px solid var(--color-border);
  padding-bottom: 10px;
  margin-bottom: 15px;
}
.field-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: 20px;
}
.field label {
  font-weight: bold;
  font-size: 0.9em;
  color: var(--color-text-maxcontrast);
  display: block;
  margin-bottom: 5px;
}
.links-section .link-group {
    margin-bottom: 15px;
}
.links-section h4 {
    margin: 0 0 5px 0;
    font-size: 1.1em;
}
.placeholder {
    font-style: italic;
    color: var(--color-text-maxcontrast);
}
.transaction-list {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.9em;
}
.transaction-list th, .transaction-list td {
    border-bottom: 1px solid var(--color-border);
    padding: 5px;
    text-align: left;
}
.amount-pos { color: green; }
.amount-neg { color: red; }
</style>
