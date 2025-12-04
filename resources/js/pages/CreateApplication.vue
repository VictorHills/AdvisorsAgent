<template>
    <div class="min-h-screen bg-background animate-fade-in">
        <main class="container mx-auto px-6 py-8 max-w-4xl">

            <!-- Step 1: Email Verification -->
            <div v-if="!isVerified" class="glass-card rounded-xl p-8 animate-slide-up">
                <div class="mb-8">
                    <h1 class="text-2xl font-bold mb-2">Verify Your Email</h1>
                    <p class="text-muted-foreground">Enter your email to get started with your application</p>
                </div>

                <!-- Email Input -->
                <div v-if="!otpSent" class="space-y-6">
                    <div v-if="error"
                         class="p-4 bg-red-500/10 border border-red-500/20 rounded-lg text-red-500 text-sm">
                        {{ error }}
                    </div>

                    <div class="space-y-2 group">
                        <label for="email" class="text-sm font-medium">Email Address *</label>
                        <input
                            id="email"
                            v-model="verificationEmail"
                            type="email"
                            required
                            :disabled="verifyLoading"
                            class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                            placeholder="student@email.com"
                            @keyup.enter="handleEmailSubmit"
                        />
                    </div>

                    <button
                        @click="handleEmailSubmit"
                        :disabled="verifyLoading || !verificationEmail"
                        class="w-full px-6 py-3 bg-primary text-primary-foreground rounded-lg font-medium hover:bg-primary/90 transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                    >
                        <span v-if="verifyLoading" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Verifying...
                        </span>
                        <span v-else>Search & Verify</span>
                    </button>
                </div>

                <!-- OTP Verification (for new students) -->
                <div v-else class="space-y-6">
                    <div class="p-4 bg-green-500/10 border border-green-500/30 rounded-lg">
                        <p class="text-sm text-green-600">OTP sent to {{ verificationEmail }}. Check your email for the
                            verification code.</p>
                    </div>

                    <div v-if="error"
                         class="p-4 bg-red-500/10 border border-red-500/20 rounded-lg text-red-500 text-sm">
                        {{ error }}
                    </div>

                    <div class="space-y-2 group">
                        <label for="otp" class="text-sm font-medium">Verification Code *</label>
                        <input
                            id="otp"
                            v-model="otp"
                            type="text"
                            required
                            :disabled="verifyLoading"
                            maxlength="6"
                            class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed text-center text-lg tracking-widest"
                            placeholder="000000"
                            @keyup.enter="handleOtpSubmit"
                        />
                    </div>

                    <button
                        @click="handleOtpSubmit"
                        :disabled="verifyLoading || !otp"
                        class="w-full px-6 py-3 bg-primary text-primary-foreground rounded-lg font-medium hover:bg-primary/90 transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                    >
                        <span v-if="verifyLoading" class="flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                 viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Verifying...
                        </span>
                        <span v-else>Verify Code</span>
                    </button>

                    <button
                        @click="resetVerification"
                        :disabled="verifyLoading"
                        class="w-full px-6 py-3 bg-transparent border border-border text-foreground rounded-lg font-medium hover:bg-muted transition-all disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                        Back to Email
                    </button>
                </div>
            </div>

            <!-- Step 2: Application Form (after verification) -->
            <form v-else @submit.prevent="handleSubmit" class="space-y-8">
                <!-- Existing Student Banner -->
                <div v-if="isExistingStudent" class="p-4 bg-blue-500/10 border border-blue-500/30 rounded-lg">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-blue-600">Existing Student Found</p>
                            <p class="text-xs text-blue-500/80">Your personal information has been prefilled and cannot
                                be edited.</p>
                        </div>
                    </div>
                </div>

                <!-- Error/Success Messages -->
                <div v-if="error" class="p-4 bg-red-500/10 border border-red-500/20 rounded-lg text-red-500 text-sm">
                    {{ error }}
                </div>

                <div v-if="success" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
                    <div class="bg-card rounded-xl p-8 text-center border border-border shadow-2xl animate-scale-in">
                        <svg class="w-16 h-16 text-emerald-500 mx-auto mb-4 animate-spin" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                  d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <h3 class="text-xl font-bold mb-2">{{ successMessage }}</h3>
                        <p class="text-muted-foreground text-sm">Redirecting to student dashboard...</p>
                    </div>
                </div>

                <!-- Personal Information -->
                <div class="glass-card rounded-xl p-6 animate-slide-up">
                    <h2 class="text-lg font-bold mb-6">Personal Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2 group">
                            <label for="first_name"
                                   class="text-sm font-medium transition-colors group-focus-within:text-primary">First
                                Name *</label>
                            <input
                                id="first_name"
                                v-model="form.first_name"
                                type="text"
                                required
                                :disabled="isExistingStudent"
                                :class="[
                                    'w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200',
                                    isExistingStudent ? 'bg-muted/50 cursor-not-allowed opacity-75' : ''
                                ]"
                                placeholder="John"
                            />
                        </div>

                        <div class="space-y-2 group">
                            <label for="middle_name"
                                   class="text-sm font-medium transition-colors group-focus-within:text-primary">Middle
                                Name</label>
                            <input
                                id="middle_name"
                                v-model="form.middle_name"
                                type="text"
                                :disabled="isExistingStudent"
                                :class="[
                                    'w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200',
                                    isExistingStudent ? 'bg-muted/50 cursor-not-allowed opacity-75' : ''
                                ]"
                                placeholder="Optional"
                            />
                        </div>

                        <div class="space-y-2 group">
                            <label for="last_name"
                                   class="text-sm font-medium transition-colors group-focus-within:text-primary">Last
                                Name *</label>
                            <input
                                id="last_name"
                                v-model="form.last_name"
                                type="text"
                                required
                                :disabled="isExistingStudent"
                                :class="[
                                    'w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200',
                                    isExistingStudent ? 'bg-muted/50 cursor-not-allowed opacity-75' : ''
                                ]"
                                placeholder="Doe"
                            />
                        </div>

                        <div class="space-y-2 group">
                            <label for="gender"
                                   class="text-sm font-medium transition-colors group-focus-within:text-primary">Gender
                                *</label>
                            <select
                                id="gender"
                                v-model="form.gender"
                                required
                                :disabled="isExistingStudent"
                                :class="[
                                    'w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200',
                                    isExistingStudent ? 'bg-muted/50 cursor-not-allowed opacity-75' : ''
                                ]"
                            >
                                <option value="">Select gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        <DatePickerField
                            id="birth_date"
                            v-model="form.birth_date"
                            label="Date of Birth"
                            :required="true"
                            :disabled="isExistingStudent"
                            :max-date="maxBirthDate"
                            :class="isExistingStudent ? 'opacity-75' : ''"
                        />

                        <div class="space-y-2 group">
                            <label for="email"
                                   class="text-sm font-medium transition-colors group-focus-within:text-primary">Email
                                *</label>
                            <input
                                id="email"
                                v-model="form.email"
                                type="email"
                                required
                                disabled
                                class="w-full px-4 py-3 bg-muted/50 border border-border rounded-lg cursor-not-allowed opacity-75"
                                placeholder="student@email.com"
                            />
                        </div>

                        <div class="space-y-2 group">
                            <label for="phone_number"
                                   class="text-sm font-medium transition-colors group-focus-within:text-primary">Phone
                                Number *</label>
                            <input
                                id="phone_number"
                                v-model="form.phone_number"
                                type="tel"
                                required
                                :disabled="isExistingStudent"
                                :class="[
                                    'w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200',
                                    isExistingStudent ? 'bg-muted/50 cursor-not-allowed opacity-75' : ''
                                ]"
                                placeholder="+1234567890"
                            />
                        </div>

                        <div class="space-y-2 group">
                            <label for="country"
                                   class="text-sm font-medium transition-colors group-focus-within:text-primary">Country
                                of Origin *</label>
                            <input
                                id="country"
                                v-model="form.country"
                                type="text"
                                required
                                :disabled="isExistingStudent"
                                :class="[
                                    'w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200',
                                    isExistingStudent ? 'bg-muted/50 cursor-not-allowed opacity-75' : ''
                                ]"
                                placeholder="Nigeria"
                            />
                        </div>

                        <div class="space-y-2 group">
                            <label for="class_of_degree"
                                   class="text-sm font-medium transition-colors group-focus-within:text-primary">Class
                                of Degree *</label>
                            <select
                                id="class_of_degree"
                                v-model="form.class_of_degree"
                                required
                                class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200"
                            >
                                <option value="">Select class</option>
                                <option value="First Class">First Class</option>
                                <option value="Second Class Upper">Second Class Upper</option>
                                <option value="Second Class Lower">Second Class Lower</option>
                                <option value="Third Class">Third Class</option>
                                <option value="Pass">Pass</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Academic Preferences -->
                <div class="glass-card rounded-xl p-6 animate-slide-up" style="animation-delay: 0.1s;">
                    <h2 class="text-lg font-bold mb-6">Academic Preferences</h2>
                    <div class="space-y-6 relative">
                        <!-- Desired Course -->
                        <div class="space-y-2 group">
                            <label for="course_search"
                                   class="text-sm font-medium transition-colors group-focus-within:text-primary">Desired
                                Course *</label>
                            <div class="relative">
                                <input
                                    id="course_search"
                                    v-model="courseSearch"
                                    type="text"
                                    placeholder="Search and select a course..."
                                    class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200"
                                    @focus="handleCourseFocus"
                                    @blur="handleCourseBlur"
                                />
                                <div v-if="showCourseDropdown"
                                     class="absolute z-50 w-full mt-1 bg-input border border-border rounded-lg shadow-lg max-h-64 overflow-y-auto">
                                    <div v-if="filteredCourses.length === 0" class="p-3 text-sm text-muted-foreground">
                                        No courses found
                                    </div>
                                    <div
                                        v-for="course in filteredCourses"
                                        :key="course.id"
                                        @mousedown.prevent="selectCourse(course)"
                                        class="px-4 py-2 cursor-pointer hover:bg-muted transition-colors"
                                    >
                                        {{ course.name }}
                                    </div>
                                </div>
                            </div>
                            <div v-if="form.course_id" class="mt-2 text-sm text-muted-foreground">
                                Selected: {{ getCourseName(form.course_id) }}
                            </div>
                        </div>

                        <!-- Schools of Choice -->
                        <div class="space-y-2">
                            <div class="flex items-center gap-2">
                                <label for="school_search" class="text-sm font-medium">Schools of Choice * <span
                                    class="text-xs text-muted-foreground">(Max 4)</span></label>
                                <div v-if="form.schools_of_choice.length > 0"
                                     class="w-5 h-5 bg-primary text-primary-foreground rounded-full flex items-center justify-center text-xs font-bold">
                                    {{ form.schools_of_choice.length }}
                                </div>
                            </div>
                            <div class="relative">
                                <input
                                    id="school_search"
                                    v-model="schoolSearch"
                                    type="text"
                                    placeholder="Search and select schools..."
                                    class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200"
                                    @focus="handleSchoolFocus"
                                    @blur="handleSchoolBlur"
                                />
                                <div v-if="showSchoolDropdown"
                                     class="absolute z-50 w-full mt-1 bg-input border border-border rounded-lg shadow-lg max-h-64 overflow-y-auto">
                                    <div v-if="filteredSchools.length === 0" class="p-3 text-sm text-muted-foreground">
                                        No schools found
                                    </div>
                                    <div
                                        v-for="school in filteredSchools"
                                        :key="school.id"
                                        @mousedown.prevent="toggleSchool(school.id)"
                                        class="px-4 py-2 cursor-pointer hover:bg-muted transition-colors flex items-center"
                                    >
                                        <input type="checkbox" :checked="form.schools_of_choice.includes(school.id)"
                                               class="mr-2" @mousedown.prevent/>
                                        {{ school.name }}
                                    </div>
                                </div>
                            </div>
                            <div v-if="form.schools_of_choice.length > 0" class="mt-3 flex flex-wrap gap-2">
                                <div v-for="schoolId in form.schools_of_choice" :key="schoolId"
                                     class="px-3 py-1 bg-primary/10 border border-primary/30 rounded-full text-sm flex items-center gap-2">
                                    {{ getSchoolName(schoolId) }}
                                    <button type="button" @click="removeSchool(schoolId)"
                                            class="text-primary hover:text-primary/70">✕
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Country Preferences -->
                        <div class="space-y-2">
                            <div class="flex items-center gap-2">
                                <label for="country_search" class="text-sm font-medium">Country Preferences * <span
                                    class="text-xs text-muted-foreground">(Max 4)</span></label>
                                <div v-if="form.country_of_preference.length > 0"
                                     class="w-5 h-5 bg-primary text-primary-foreground rounded-full flex items-center justify-center text-xs font-bold">
                                    {{ form.country_of_preference.length }}
                                </div>
                            </div>
                            <div class="relative">
                                <input
                                    id="country_pref_search"
                                    v-model="countrySearch"
                                    type="text"
                                    placeholder="Search and select countries..."
                                    class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200"
                                    @focus="handleCountryFocus"
                                    @blur="handleCountryBlur"
                                />
                                <div v-if="showCountryDropdown"
                                     class="absolute z-50 w-full mt-1 bg-input border border-border rounded-lg shadow-lg max-h-64 overflow-y-auto">
                                    <div v-if="filteredCountries.length === 0"
                                         class="p-3 text-sm text-muted-foreground">No countries found
                                    </div>
                                    <div
                                        v-for="country in filteredCountries"
                                        :key="country.id"
                                        @mousedown.prevent="toggleCountry(country.id)"
                                        class="px-4 py-2 cursor-pointer hover:bg-muted transition-colors flex items-center"
                                    >
                                        <input type="checkbox"
                                               :checked="form.country_of_preference.includes(country.id)" class="mr-2"
                                               @mousedown.prevent/>
                                        {{ country.name }}
                                    </div>
                                </div>
                            </div>
                            <div v-if="form.country_of_preference.length > 0" class="mt-3 flex flex-wrap gap-2">
                                <div v-for="countryId in form.country_of_preference" :key="countryId"
                                     class="px-3 py-1 bg-primary/10 border border-primary/30 rounded-full text-sm flex items-center gap-2">
                                    {{ getCountryName(countryId) }}
                                    <button type="button" @click="removeCountry(countryId)"
                                            class="text-primary hover:text-primary/70">✕
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Information -->
                <div class="glass-card rounded-xl p-6 animate-slide-up" style="animation-delay: 0.2s;">
                    <h2 class="text-lg font-bold mb-6">Additional Information</h2>
                    <div class="space-y-6">
                        <div class="space-y-2 group">
                            <label for="additional_notes"
                                   class="text-sm font-medium transition-colors group-focus-within:text-primary">Additional
                                Notes</label>
                            <textarea
                                id="additional_notes"
                                v-model="form.additional_notes"
                                rows="4"
                                class="w-full px-4 py-3 bg-input border border-border rounded-lg focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent transition-all duration-200 resize-none"
                                placeholder="Any additional information..."
                            ></textarea>
                        </div>

                        <!-- File Upload -->
                        <div class="space-y-2">
                            <label class="text-sm font-medium">Application Documents</label>
                            <div
                                class="border-2 border-dashed border-border rounded-lg p-8 text-center hover:border-primary transition-all duration-300 cursor-pointer"
                                :class="{ 'bg-primary/5 border-primary': isDragOver }"
                                @click="$refs.documentInput.click()"
                                @drop.prevent="handleDrop"
                                @dragover.prevent="isDragOver = true"
                                @dragleave.prevent="isDragOver = false"
                            >
                                <svg class="w-12 h-12 mx-auto text-muted-foreground mb-4" fill="none"
                                     stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <p class="text-sm text-muted-foreground mb-2">Click to upload or drag and drop</p>
                                <p class="text-xs text-muted-foreground">PDF, DOC, DOCX (max. 10MB each)</p>
                            </div>
                            <div v-if="form.application_documents.length > 0" class="mt-4 space-y-2">
                                <div v-for="(file, index) in form.application_documents" :key="index"
                                     class="flex items-center justify-between bg-muted/50 p-3 rounded border border-border">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <span class="text-sm">{{ file.name }}</span>
                                        <span class="text-xs text-muted-foreground">({{ (file.size / 1024).toFixed(2) }} KB)</span>
                                    </div>
                                    <button type="button" @click="removeFile(index)"
                                            class="text-destructive text-xs font-medium">Remove
                                    </button>
                                </div>
                            </div>
                            <input ref="documentInput" type="file" multiple accept=".pdf,.doc,.docx" class="hidden"
                                   @change="handleFileUpload"/>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center justify-end space-x-4 animate-slide-up" style="animation-delay: 0.3s;">
                    <router-link to="/dashboard"
                                 class="px-6 py-3 border border-border rounded-lg font-medium hover:bg-muted transition-all duration-200">
                        Cancel
                    </router-link>
                    <button
                        type="button"
                        @click="showReviewModal = true"
                        class="px-6 py-3 bg-primary text-primary-foreground rounded-lg font-medium hover:bg-primary/90 transition-all duration-200 hover:shadow-lg"
                    >
                        Review & Submit
                    </button>
                </div>
            </form>

            <!-- Review Modal (keeping your existing modal structure) -->
            <div v-if="showReviewModal"
                 class="fixed inset-0 backdrop-blur-sm bg-black/30 flex items-center justify-center z-50 p-4 overflow-y-auto">
                <div
                    class="bg-card rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto border border-border shadow-2xl">
                    <div
                        class="sticky top-0 bg-gradient-to-r from-primary/10 to-primary/5 border-b border-border p-6 flex items-center justify-between backdrop-blur-2xl">
                        <div>
                            <h2 class="text-xl font-bold">Review Your Application</h2>
                            <p class="text-sm text-muted-foreground mt-1">Please verify your details before
                                submitting</p>
                        </div>
                        <button type="button" @click="showReviewModal = false"
                                class="text-muted-foreground hover:text-foreground transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- Personal Info -->
                        <div class="space-y-4">
                            <h3 class="text-sm font-semibold text-primary uppercase tracking-wide">Personal
                                Information</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="p-3 bg-muted/30 rounded-lg border border-border/50">
                                    <p class="text-xs text-muted-foreground font-medium mb-1">Full Name</p>
                                    <p class="font-medium">{{ form.first_name }} {{ form.middle_name }}
                                        {{ form.last_name }}</p>
                                </div>
                                <div class="p-3 bg-muted/30 rounded-lg border border-border/50">
                                    <p class="text-xs text-muted-foreground font-medium mb-1">Email</p>
                                    <p class="font-medium text-sm break-all">{{ form.email }}</p>
                                </div>
                                <div class="p-3 bg-muted/30 rounded-lg border border-border/50">
                                    <p class="text-xs text-muted-foreground font-medium mb-1">Phone</p>
                                    <p class="font-medium">{{ form.phone_number }}</p>
                                </div>
                                <div class="p-3 bg-muted/30 rounded-lg border border-border/50">
                                    <p class="text-xs text-muted-foreground font-medium mb-1">Gender</p>
                                    <p class="font-medium">{{ form.gender }}</p>
                                </div>
                                <div class="p-3 bg-muted/30 rounded-lg border border-border/50">
                                    <p class="text-xs text-muted-foreground font-medium mb-1">Date of Birth</p>
                                    <p class="font-medium">{{ form.birth_date }}</p>
                                </div>
                                <div class="p-3 bg-muted/30 rounded-lg border border-border/50">
                                    <p class="text-xs text-muted-foreground font-medium mb-1">Country</p>
                                    <p class="font-medium">{{ form.country }}</p>
                                </div>
                                <div class="p-3 bg-muted/30 rounded-lg border border-border/50">
                                    <p class="text-xs text-muted-foreground font-medium mb-1">Class of Degree</p>
                                    <p class="font-medium">{{ form.class_of_degree }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Academic Info -->
                        <div class="space-y-4">
                            <h3 class="text-sm font-semibold text-primary uppercase tracking-wide">Academic
                                Preferences</h3>
                            <div class="space-y-3">
                                <div class="p-3 bg-muted/30 rounded-lg border border-border/50">
                                    <p class="text-xs text-muted-foreground font-medium mb-1">Desired Course</p>
                                    <p class="font-medium">{{ getCourseName(form.course_id) }}</p>
                                </div>
                                <div class="p-3 bg-muted/30 rounded-lg border border-border/50">
                                    <p class="text-xs text-muted-foreground font-medium mb-1">Schools of Choice</p>
                                    <div class="flex flex-wrap gap-2 mt-2">
                                        <span v-for="schoolId in form.schools_of_choice" :key="schoolId"
                                              class="px-2 py-1 bg-primary/20 text-primary rounded text-xs font-medium">
                                            {{ getSchoolName(schoolId) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="p-3 bg-muted/30 rounded-lg border border-border/50">
                                    <p class="text-xs text-muted-foreground font-medium mb-1">Country Preferences</p>
                                    <div class="flex flex-wrap gap-2 mt-2">
                                        <span v-for="countryId in form.country_of_preference" :key="countryId"
                                              class="px-2 py-1 bg-primary/20 text-primary rounded text-xs font-medium">
                                            {{ getCountryName(countryId) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Notes -->
                        <div v-if="form.additional_notes" class="space-y-4">
                            <h3 class="text-sm font-semibold text-primary uppercase tracking-wide">Additional Notes</h3>
                            <div class="p-3 bg-muted/30 rounded-lg border border-border/50">
                                <p class="text-sm text-muted-foreground whitespace-pre-wrap">{{
                                        form.additional_notes
                                    }}</p>
                            </div>
                        </div>

                        <!-- Documents -->
                        <div v-if="form.application_documents.length > 0" class="space-y-4">
                            <h3 class="text-sm font-semibold text-primary uppercase tracking-wide">Attached
                                Documents</h3>
                            <div class="space-y-2">
                                <div v-for="(file, index) in form.application_documents" :key="index"
                                     class="p-3 bg-muted/30 rounded-lg border border-border/50 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-primary flex-shrink-0" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <div>
                                        <p class="font-medium text-sm">{{ file.name }}</p>
                                        <p class="text-xs text-muted-foreground">{{ (file.size / 1024).toFixed(2) }} KB</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-border">
                            <button type="button" @click="showReviewModal = false"
                                    class="px-6 py-3 border border-border rounded-lg font-medium hover:bg-muted transition-all duration-200">
                                Go Back & Edit
                            </button>
                            <button
                                type="button"
                                @click="handleSubmit"
                                :disabled="loading"
                                class="px-6 py-3 bg-primary text-primary-foreground rounded-lg font-medium hover:bg-primary/90 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                            >
                                <svg v-if="loading" class="w-4 h-4 animate-spin" fill="none" stroke="currentColor"
                                     viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                            stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span>{{ loading ? 'Submitting...' : 'Confirm & Submit' }}</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</template>

<script>
import {ref, onMounted, computed} from 'vue'
import {useRouter} from 'vue-router'
import {applicationsAPI, coursesAPI, countriesAPI, schoolsAPI, studentsAPI, authAPI} from '../services/api'
import DatePickerField from '../components/DatePickerField.vue'

export default {
    name: 'CreateApplication',
    components: {DatePickerField},
    setup() {
        const router = useRouter()

        // Verification state
        const verificationEmail = ref('')
        const otp = ref('')
        const otpSent = ref(false)
        const isVerified = ref(false)
        const isExistingStudent = ref(false)
        const verifyLoading = ref(false)
        const existingStudentData = ref(null)

        // Form state
        const loading = ref(false)
        const error = ref(null)
        const success = ref(false)
        const successMessage = ref('Application submitted successfully!')
        const isDragOver = ref(false)
        const showReviewModal = ref(false)

        // Dropdown data
        const courses = ref([])
        const schools = ref([])
        const countries = ref([])

        // Search states
        const courseSearch = ref('')
        const schoolSearch = ref('')
        const countrySearch = ref('')
        const showCourseDropdown = ref(false)
        const showSchoolDropdown = ref(false)
        const showCountryDropdown = ref(false)

        // Form data
        const form = ref({
            first_name: '',
            middle_name: '',
            last_name: '',
            gender: '',
            birth_date: '',
            email: '',
            phone_number: '',
            country: '',
            class_of_degree: '',
            course_id: '',
            schools_of_choice: [],
            country_of_preference: [],
            additional_notes: '',
            application_documents: []
        })

        // Email verification
        const handleEmailSubmit = async () => {
            try {
                verifyLoading.value = true
                error.value = ''

                const response = await studentsAPI.validateStudent(verificationEmail.value)

                if (response.data?.status) {
                    // Existing student found - prefill all data
                    isExistingStudent.value = true
                    existingStudentData.value = response.data.data
                    isVerified.value = true
                    prefillExistingStudent(response.data.data)
                }
            } catch (err) {
                if (err.response?.data?.error?.status_code === 400) {
                    // New student - OTP sent
                    otpSent.value = true
                    error.value = ''
                } else {
                    error.value = err.response?.data?.error?.message || 'Failed to verify email'
                }
            } finally {
                verifyLoading.value = false
            }
        }

        const handleOtpSubmit = async () => {
            try {
                verifyLoading.value = true
                error.value = ''

                const response = await authAPI.verifyOtp(verificationEmail.value, otp.value, 'email')

                if (response.data?.status) {
                    // OTP verified - new student, only prefill email
                    isVerified.value = true
                    isExistingStudent.value = false
                    form.value.email = verificationEmail.value
                } else {
                    error.value = response.data?.message || 'OTP verification failed'
                }
            } catch (err) {
                error.value = err.response?.data?.message || err.response?.data?.error?.message || 'Invalid verification code'
            } finally {
                verifyLoading.value = false
            }
        }

        const prefillExistingStudent = (studentData) => {
            form.value.first_name = studentData.first_name || ''
            form.value.middle_name = studentData.middle_name || ''
            form.value.last_name = studentData.last_name || ''
            form.value.gender = studentData.gender || ''
            form.value.birth_date = studentData.birth_date || ''
            form.value.email = studentData.email || ''
            form.value.phone_number = studentData.phone_number || ''
            form.value.country = studentData.country || ''
        }

        const resetVerification = () => {
            verificationEmail.value = ''
            otp.value = ''
            otpSent.value = false
            error.value = ''
        }

        // Filtered lists
        const filteredCourses = computed(() => {
            const list = Array.isArray(courses.value) ? courses.value : []
            if (!courseSearch.value) return list
            return list.filter(c => c.name.toLowerCase().includes(courseSearch.value.toLowerCase()))
        })

        // Max birthdate (must be at least 16 years old)
        const maxBirthDate = computed(() => {
            const date = new Date()
            date.setFullYear(date.getFullYear() - 16)
            return date.toISOString().split('T')[0]
        })

        const filteredSchools = computed(() => {
            const list = Array.isArray(schools.value) ? schools.value : []
            if (!schoolSearch.value) return list
            return list.filter(s => s.name.toLowerCase().includes(schoolSearch.value.toLowerCase()))
        })

        const filteredCountries = computed(() => {
            const list = Array.isArray(countries.value) ? countries.value : []
            if (!countrySearch.value) return list
            return list.filter(c => c.name.toLowerCase().includes(countrySearch.value.toLowerCase()))
        })

        // Fetch functions
        const fetchCourses = async () => {
            try {
                const response = await coursesAPI.getAll()
                courses.value = response.data?.data?.data || []
            } catch (err) {
                console.error('Error fetching courses:', err)
            }
        }

        const fetchSchools = async () => {
            try {
                const response = await schoolsAPI.getAll()
                schools.value = response.data?.data?.data || []
            } catch (err) {
                console.error('Error fetching schools:', err)
            }
        }

        const fetchCountries = async () => {
            try {
                const response = await countriesAPI.getAll()
                countries.value = response.data?.data?.data || []
            } catch (err) {
                console.error('Error fetching countries:', err)
            }
        }

        // Dropdown handlers
        const handleCourseFocus = () => {
            showCourseDropdown.value = true
            if (courses.value.length === 0) fetchCourses()
        }
        const handleCourseBlur = () => setTimeout(() => showCourseDropdown.value = false, 200)

        const handleSchoolFocus = () => {
            showSchoolDropdown.value = true
            if (schools.value.length === 0) fetchSchools()
        }
        const handleSchoolBlur = () => setTimeout(() => showSchoolDropdown.value = false, 200)

        const handleCountryFocus = () => {
            showCountryDropdown.value = true
            if (countries.value.length === 0) fetchCountries()
        }
        const handleCountryBlur = () => setTimeout(() => showCountryDropdown.value = false, 200)

        // Selection handlers
        const selectCourse = (course) => {
            form.value.course_id = course.id
            courseSearch.value = course.name
            showCourseDropdown.value = false
        }

        const toggleSchool = (id) => {
            const idx = form.value.schools_of_choice.indexOf(id)
            if (idx > -1) {
                form.value.schools_of_choice.splice(idx, 1)
            } else if (form.value.schools_of_choice.length < 4) {
                form.value.schools_of_choice.push(id)
            }
        }

        const removeSchool = (id) => {
            form.value.schools_of_choice = form.value.schools_of_choice.filter(s => s !== id)
        }

        const toggleCountry = (id) => {
            const idx = form.value.country_of_preference.indexOf(id)
            if (idx > -1) {
                form.value.country_of_preference.splice(idx, 1)
            } else if (form.value.country_of_preference.length < 4) {
                form.value.country_of_preference.push(id)
            }
        }

        const removeCountry = (id) => {
            form.value.country_of_preference = form.value.country_of_preference.filter(c => c !== id)
        }

        // Name getters
        const getCourseName = (id) => courses.value.find(c => c.id === id)?.name || ''
        const getSchoolName = (id) => schools.value.find(s => s.id === id)?.name || ''
        const getCountryName = (id) => countries.value.find(c => c.id === id)?.name || ''

        // File handling
        const handleFileUpload = (e) => {
            const files = Array.from(e.target.files)
            files.forEach(file => {
                if (file.size <= 10 * 1024 * 1024) {
                    form.value.application_documents.push(file)
                }
            })
            e.target.value = ''
        }

        const handleDrop = (e) => {
            isDragOver.value = false
            handleFileUpload({target: {files: e.dataTransfer.files}})
        }

        const removeFile = (idx) => form.value.application_documents.splice(idx, 1)

        // Submit
        const handleSubmit = async () => {
            try {
                loading.value = true
                error.value = null

                const response = await applicationsAPI.create(form.value)
                successMessage.value = response.data?.message || 'Application submitted successfully!'
                success.value = true
                showReviewModal.value = false

                setTimeout(() => router.push('/applications'), 2000)
            } catch (err) {
                error.value = err.response?.data?.message || 'Failed to submit application'
            } finally {
                loading.value = false
            }
        }

        onMounted(() => {
            fetchCourses()
            fetchSchools()
            fetchCountries()
        })

        return {
            // Verification
            verificationEmail, otp, otpSent, isVerified, isExistingStudent, verifyLoading,
            handleEmailSubmit, handleOtpSubmit, resetVerification,
            // Form
            form, loading, error, success, successMessage, isDragOver, showReviewModal, maxBirthDate,
            // Dropdowns
            courses, schools, countries,
            courseSearch, schoolSearch, countrySearch,
            showCourseDropdown, showSchoolDropdown, showCountryDropdown,
            filteredCourses, filteredSchools, filteredCountries,
            // Handlers
            handleCourseFocus, handleCourseBlur, handleSchoolFocus, handleSchoolBlur,
            handleCountryFocus, handleCountryBlur, selectCourse,
            toggleSchool, removeSchool, toggleCountry, removeCountry,
            getCourseName, getSchoolName, getCountryName,
            handleFileUpload, handleDrop, removeFile, handleSubmit
        }
    }
}
</script>
