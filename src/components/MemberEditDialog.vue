<template>
  <div class="modal-mask">
    <div class="modal-wrapper">
      <div class="modal-container">

        <div class="modal-header">
          <h3>{{ isNewMember ? 'Neues Mitglied anlegen' : 'Mitglied bearbeiten' }}</h3>
        </div>

        <div class="modal-body">
          <div v-if="loading" class="loading-state">Laden...</div>
          <form v-else @submit.prevent="saveMember">
            <div class="form-group">
              <label>Benutzer-ID</label>
              <input type="text" :value="localMember.user_id" disabled class="form-control disabled" />
            </div>

            <fieldset class="form-section">
              <legend>Persönliche Daten</legend>
              <div class="form-row">
                <div class="form-group half">
                  <label>Vorname *</label>
                  <input type="text" v-model="localMember.firstname" class="form-control" required />
                </div>
                <div class="form-group half">
                  <label>Nachname *</label>
                  <input type="text" v-model="localMember.lastname" class="form-control" required />
                </div>
              </div>
              <div class="form-group">
                <label>E-Mail *</label>
                <input type="email" v-model="localMember.email" class="form-control" required />
              </div>
              <div class="form-group">
                <label>Telefon</label>
                <input type="tel" v-model="localMember.phone" class="form-control" />
              </div>
            </fieldset>

            <fieldset class="form-section">
              <legend>Anschrift</legend>
              <div class="form-group">
                <label>Straße</label>
                <input type="text" v-model="localMember.street" class="form-control" />
              </div>
              <div class="form-row">
                <div class="form-group one-third">
                  <label>PLZ</label>
                  <input type="text" v-model="localMember.zip" class="form-control" />
                </div>
                <div class="form-group two-thirds">
                  <label>Ort</label>
                  <input type="text" v-model="localMember.city" class="form-control" />
                </div>
              </div>
            </fieldset>

            <fieldset class="form-section">
              <legend>Vereinsdaten</legend>
              <div class="form-group">
                <label>Mitgliedsnummer</label>
                <input 
                  type="text" 
                  v-model="localMember.mitgliedsnummer" 
                  class="form-control" 
                />
              </div>

              <div class="form-group">
                <label>Eintrittsdatum</label>
                <input 
                  type="date" 
                  v-model="localMember.eintrittsdatum" 
                  class="form-control" 
                />
              </div>

              <div class="form-group">
                <label>Status</label>
                <select v-model="localMember.status" class="form-control">
                  <option value="aktiv">Aktiv</option>
                  <option value="passiv">Passiv</option>
                  <option value="ehemalig">Ehemalig</option>
                  <option value="ehrenmitglied">Ehrenmitglied</option>
                </select>
              </div>
            </fieldset>
            
            <div v-if="error" class="error-message">
                {{ error }}
            </div>
          </form>
        </div>

        <div class="modal-footer">
          <button class="button" @click="cancelEdit">
             Abbrechen
          </button>
          <button v-if="!loading" class="button primary" @click="saveMember" :disabled="saving">
             <span v-if="saving">Speichern...</span>
             <span v-else>Speichern</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
/**
 * © 2026 Stefan Schulz – Alle Rechte vorbehalten.
 */
import axios from '@nextcloud/axios'
import { generateUrl } from '@nextcloud/router'

export default {
  name: 'MemberEditDialog',
  props: {
    member: {
      type: Object,
      required: true
    }
  },
  computed: {
    isNewMember() {
      return !this.member.id && !this.member.userId
    }
  },
  data() {
    return {
      localMember: { 
        ...this.member,
        firstname: this.member.firstname || '',
        lastname: this.member.lastname || '',
        email: this.member.email || '',
        phone: this.member.phone || '',
        street: this.member.street || '',
        zip: this.member.zip || '',
        city: this.member.city || '',
        mitgliedsnummer: this.member.mitgliedsnummer || '',
        status: this.member.status || 'aktiv'
      },
      loading: false,
      saving: false,
      error: ''
    }
  },
  async mounted() {
      // Only fetch full details if editing existing member
      if (this.isNewMember) {
          this.loading = false;
          return;
      }
      
      this.loading = true;
      try {
          const memberId = this.member.id || this.member.userId;
          const url = generateUrl('/apps/clubsuite-core/members/' + memberId);
          const response = await axios.get(url);
          // Merge fetched data into localMember
          this.localMember = { ...this.localMember, ...response.data };
          
          // Compat: ensure street is set if address came back or vice versa (though we use street now)
          // Backend returns 'street' now.
      } catch (e) {
          this.error = 'Details konnten nicht geladen werden.';
          console.error(e);
      } finally {
          this.loading = false;
      }
  },
  methods: {
    cancelEdit() {
      this.$emit('cancelled')
    },
    async saveMember() {
      if (!this.localMember.firstname || !this.localMember.lastname || !this.localMember.email) {
          this.error = 'Bitte füllen Sie alle Pflichtfelder (Vorname, Nachname, E-Mail) aus.';
          return;
      }

      this.saving = true;
      this.error = '';
      
      const payload = {
          // Club Data
          mitgliedsnummer: this.localMember.mitgliedsnummer,
          eintrittsdatum: this.localMember.eintrittsdatum,
          status: this.localMember.status,
          // Personal Data
          firstname: this.localMember.firstname,
          lastname: this.localMember.lastname,
          email: this.localMember.email,
          phone: this.localMember.phone,
          street: this.localMember.street,
          zip: this.localMember.zip,
          city: this.localMember.city
      };
      
      try {
          if (this.isNewMember) {
              // Create new member (POST)
              const url = generateUrl('/apps/clubsuite-core/members');
              const response = await axios.post(url, payload);
              this.$emit('updated', response.data);
          } else {
              // Update existing member (PUT)
              const memberId = this.localMember.id || this.localMember.userId;
              const url = generateUrl('/apps/clubsuite-core/members/' + memberId);
              await axios.put(url, payload);
              this.$emit('updated', this.localMember);
          }
      } catch (e) {
          console.error(e);
          this.error = 'Fehler beim Speichern: ' + (e.response?.data?.error || e.response?.data?.message || e.message);
      } finally {
          this.saving = false;
      }
    }
  }
}
</script>

<style scoped>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  width: 500px;
  margin: 0px auto;
  padding: 20px 30px;
  background-color: var(--color-main-background);
  border-radius: 5px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;
  color: var(--color-main-text);
}

.modal-header h3 {
  margin-top: 0;
  color: var(--color-primary);
}

.modal-body {
  margin: 20px 0;
  max-height: 60vh;
  overflow-y: auto;
}
.loading-state {
    text-align: center;
    padding: 20px;
    font-style: italic;
}

.form-section {
  border: 1px solid var(--color-border);
  padding: 10px;
  margin-bottom: 15px;
  border-radius: 5px;
}

.form-section legend {
  padding: 0 5px;
  font-weight: bold;
  color: var(--color-text-maxcontrast);
}

.form-row {
  display: flex;
  gap: 15px;
}

.form-group.half {
    width: 50%;
}
.form-group.one-third {
    width: 30%;
}
.form-group.two-thirds {
    width: 70%;
}

.form-group {
    margin-bottom: 15px;
}
.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
}
.form-control {
    width: 100%;
    padding: 8px;
    border: 1px solid var(--color-border);
    border-radius: 3px;
    background-color: var(--color-main-background);
    color: var(--color-main-text);
}
.form-control.disabled {
    background-color: var(--color-background-dark);
    color: var(--color-text-maxcontrast);
}

.modal-footer {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
}

.button {
    padding: 8px 15px;
    border-radius: 3px;
    cursor: pointer;
    border: 1px solid var(--color-border);
    background-color: var(--color-main-background);
    color: var(--color-main-text);
}
.button.primary {
    background-color: var(--color-primary);
    color: var(--color-primary-text);
    border: none;
}
.button:disabled {
    opacity: 0.7;
    cursor: not-allowed;
}
.error-message {
    color: #e9322d;
    margin-top: 10px;
}
</style>
