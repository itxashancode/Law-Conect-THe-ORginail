<template>
  <div class="relative z-10">
    <Dialog as="div" @close="isOpen = false" class="relative z-50">
      <DialogOverlay class="fixed inset-0 bg-onyx/50 backdrop-blur-sm transition-opacity duration-300" />
      <DialogContent class="fixed inset-0 flex items-center justify-center p-4 overflow-y-auto">
        <div class="relative mx-auto w-full max-w-2xl">
          <div class="bg-linen rounded-bespoke border border-gold-200/50 shadow-luxury p-6">
            <div class="flex items-center justify-between mb-6">
              <h3 class="text-2xl font-bold text-onyx">Book Consultation</h3>
              <button
                @click="isOpen = false"
                class="p-2 text-gold-500 hover:text-gold-600 transition-colors duration-200"
              >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
              </button>
            </div>

            <!-- Selected Lawyer Info -->
            <div class="bg-onyx/5 rounded-bespoke p-4 mb-6 border border-onyx/10">
              <div class="flex items-center gap-4">
                <img
                  :src="selectedLawyer.profile_image || '/images/default-lawyer.jpg'"
                  :alt="selectedLawyer.name"
                  class="w-16 h-16 rounded-full object-cover"
                />
                <div class="flex-1">
                  <h4 class="text-lg font-semibold text-onyx">{{ selectedLawyer.name }}</h4>
                  <p class="text-gold-600">{{ selectedLawyer.title }}</p>
                  <p class="text-onyx/70">{{ selectedLawyer.firm }}</p>
                </div>
              </div>
            </div>

            <!-- Booking Form -->
            <form @submit.prevent="handleBook" class="space-y-6">
              <!-- Personal Information -->
              <div class="space-y-4">
                <h4 class="text-lg font-semibold text-onyx">Personal Information</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <input
                    v-model="formData.name"
                    type="text"
                    placeholder="Full Name"
                    class="w-full px-4 py-2 bg-linen border border-gold-200/50 rounded-bespoke focus:ring-2 focus:ring-gold-500 focus:border-transparent transition-all duration-200"
                    required
                  />
                  <input
                    v-model="formData.email"
                    type="email"
                    placeholder="Email Address"
                    class="w-full px-4 py-2 bg-linen border border-gold-200/50 rounded-bespoke focus:ring-2 focus:ring-gold-500 focus:border-transparent transition-all duration-200"
                    required
                  />
                </div>
                <input
                  v-model="formData.phone"
                  type="tel"
                  placeholder="Phone Number"
                  class="w-full px-4 py-2 bg-linen border border-gold-200/50 rounded-bespoke focus:ring-2 focus:ring-gold-500 focus:border-transparent transition-all duration-200"
                />
              </div>

              <!-- Appointment Date -->
              <div class="space-y-4">
                <h4 class="text-lg font-semibold text-onyx">Select Date</h4>
                <Calendar
                  v-model="selectedDate"
                  :show-day="true"
                  :show-month="true"
                  :show-year="true"
                  :max-date="new Date(new Date().setFullYear(new Date().getFullYear() + 1))"
                  :min-date="new Date()"
                  class="bg-linen border border-gold-200/50 rounded-bespoke"
                />
              </div>

              <!-- Available Time Slots -->
              <div class="space-y-4">
                <h4 class="text-lg font-semibold text-onyx">Select Time</h4>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                  <button
                    v-for="time in availableTimes"
                    :key="time"
                    @click="selectedTime = time"
                    type="button"
                    :class="{
                      'bg-gold-500 text-linen': selectedTime === time,
                      'bg-linen border border-gold-200/50': selectedTime !== time
                    }"
                    class="w-full px-3 py-2 rounded-bespoke font-medium transition-colors duration-200 hover:bg-gold-50"
                  >
                    {{ time }}
                  </button>
                </div>
              </div>

              <!-- Case Details -->
              <div class="space-y-4">
                <h4 class="text-lg font-semibold text-onyx">Case Details</h4>
                <textarea
                  v-model="formData.details"
                  rows="4"
                  placeholder="Please provide a brief description of your legal issue..."
                  class="w-full px-4 py-2 bg-linen border border-gold-200/50 rounded-bespoke focus:ring-2 focus:ring-gold-500 focus:border-transparent transition-all duration-200 resize-none"
                  required
                </textarea>
              </div>

              <!-- Terms and Submit -->
              <div class="flex items-center gap-2">
                <input
                  v-model="formData.terms"
                  type="checkbox"
                  class="w-4 h-4 bg-linen border border-gold-200/50 rounded focus:ring-2 focus:ring-gold-500 focus:border-transparent"
                />
                <label class="text-sm text-onyx/70">
                  I agree to the <span class="text-gold-500 cursor-pointer hover:text-gold-600">Terms and Conditions</span>
                </label>
              </div>

              <div class="flex gap-3 pt-4">
                <button
                  type="button"
                  @click="isOpen = false"
                  class="px-6 py-2 bg-onyx/10 text-onyx hover:bg-onyx/20 transition-colors duration-200 rounded-bespoke font-medium"
                >
                  Cancel
                </button>
                <button
                  type="submit"
                  :disabled="!isFormValid"
                  class="flex-1 px-6 py-2 bg-gold-500 text-linen hover:bg-gold-600 transition-colors duration-200 rounded-bespoke font-medium disabled:bg-gold-400 disabled:opacity-50"
                >
                  Confirm Booking
                </button>
              </div>
            </form>
          </div>
        </div>
      <DialogContent>
    <Dialog>
  </div>
<template>

<script>
export default {
  props: {
    selectedLawyer: {
      type: Object,
      required: true
    }
  },

  data() {
    return {
      isOpen: false,
      selectedDate: null,
      selectedTime: null,
      formData: {
        name: '',
        email: '',
        phone: '',
        details: '',
        terms: false
      }
    }
  },

  computed: {
    availableTimes() {
      // Mock available time slots for the selected date
      const baseTimes = [
        '08:00 AM', 'É:00 AM', 'É:30 AM', 'É:00 AM',
        '10:30 AM', 'É:00 AM', 'É:30 PM', 'É:00 PM'
      ]
      return this.selectedDate ? baseTimes : []
    },

    isFormValid() {
      return this.formData.name &&
             this.formData.email &&
             this.formData.phone &&
             this.formData.details &&
             this.formData.terms &&
             this.selectedDate &&
             this.selectedTime
    }
  },

  methods: {
    open() {
      this.isOpen = true
    },

    handleBook() {
      // Here you would typically make an API call to create the booking
      console.log('Booking data:', {
        lawyer: this.selectedLawyer,
        date: this.selectedDate,
        time: this.selectedTime,
        ...this.formData
      })

      // Close dialog and reset form
      this.isOpen = false
      this.resetForm()

      // Emit success event
      this.$emit('booking-created', {
        lawyer: this.selectedLawyer,
        date: this.selectedDate,
        time: this.selectedTime,
        ...this.formData
      })
    },

    resetForm() {
      this.selectedDate = null
      this.selectedTime = null
      this.formData = {
        name: '',
        email: '',
        phone: '',
        details: '',
        terms: false
      }
    }
  }
}
</script>