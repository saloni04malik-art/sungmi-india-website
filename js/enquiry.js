/**
 * SUNGMI INDIA - PROJECT ENQUIRY CONTROLLER
 * Handles international country code selection, real-time live validation,
 * drag-and-drop file upload previews, and asynchronous AJAX submission.
 */

// Worldwide Country Data for International Maritime Clients
const WORLD_COUNTRIES = [
  { code: 'IN', name: 'India', dial: '+91', flag: '🇮🇳', regex: /^[6-9]\d{9}$/, placeholder: '98765 43210' },
  { code: 'AE', name: 'UAE', dial: '+971', flag: '🇦🇪', regex: /^5\d{8}$/, placeholder: '50 123 4567' },
  { code: 'KR', name: 'South Korea', dial: '+82', flag: '🇰🇷', regex: /^1[0-9]\d{7,8}$/, placeholder: '10 1234 5678' },
  { code: 'US', name: 'United States', dial: '+1', flag: '🇺🇸', regex: /^\d{10}$/, placeholder: '201 555 0123' },
  { code: 'GB', name: 'United Kingdom', dial: '+44', flag: '🇬🇧', regex: /^7\d{9}$/, placeholder: '7123 456789' },
  { code: 'SG', name: 'Singapore', dial: '+65', flag: '🇸🇬', regex: /^[89]\d{7}$/, placeholder: '8123 4567' },
  { code: 'AU', name: 'Australia', dial: '+61', flag: '🇦🇺', regex: /^4\d{8}$/, placeholder: '412 345 678' },
  { code: 'SA', name: 'Saudi Arabia', dial: '+966', flag: '🇸🇦', regex: /^5\d{8}$/, placeholder: '50 123 4567' },
  { code: 'QA', name: 'Qatar', dial: '+974', flag: '🇶🇦', regex: /^[3567]\d{7}$/, placeholder: '3312 3456' },
  { code: 'OM', name: 'Oman', dial: '+968', flag: '🇴🇲', regex: /^9\d{7}$/, placeholder: '9123 4567' },
  { code: 'KW', name: 'Kuwait', dial: '+965', flag: '🇰🇼', regex: /^[569]\d{7}$/, placeholder: '5123 4567' },
  { code: 'BH', name: 'Bahrain', dial: '+973', flag: '🇧🇭', regex: /^3\d{7}$/, placeholder: '3123 4567' },
  { code: 'NO', name: 'Norway', dial: '+47', flag: '🇳🇴', regex: /^[49]\d{7}$/, placeholder: '412 34 567' },
  { code: 'DE', name: 'Germany', dial: '+49', flag: '🇩🇪', regex: /^1[5-7]\d{8,9}$/, placeholder: '151 23456789' },
  { code: 'NL', name: 'Netherlands', dial: '+31', flag: '🇳🇱', regex: /^6\d{8}$/, placeholder: '6 12345678' },
  { code: 'FR', name: 'France', dial: '+33', flag: '🇫🇷', regex: /^[67]\d{8}$/, placeholder: '6 12 34 56 78' },
  { code: 'IT', name: 'Italy', dial: '+39', flag: '🇮🇹', regex: /^3\d{9}$/, placeholder: '312 345 6789' },
  { code: 'JP', name: 'Japan', dial: '+81', flag: '🇯🇵', regex: /^[789]0\d{8}$/, placeholder: '90 1234 5678' },
  { code: 'CN', name: 'China', dial: '+86', flag: '🇨🇳', regex: /^1[3-9]\d{9}$/, placeholder: '138 0000 0000' },
  { code: 'MY', name: 'Malaysia', dial: '+60', flag: '🇲🇾', regex: /^1[0-9]\d{7,8}$/, placeholder: '12 345 6789' },
  { code: 'ID', name: 'Indonesia', dial: '+62', flag: '🇮🇩', regex: /^8\d{8,11}$/, placeholder: '812 3456 7890' },
  { code: 'VN', name: 'Vietnam', dial: '+84', flag: '🇻🇳', regex: /^[35789]\d{8}$/, placeholder: '91 234 5678' },
  { code: 'GR', name: 'Greece', dial: '+30', flag: '🇬🇷', regex: /^69\d{8}$/, placeholder: '691 234 5678' },
  { code: 'TR', name: 'Turkey', dial: '+90', flag: '🇹🇷', regex: /^5\d{9}$/, placeholder: '532 123 4567' },
  { code: 'BR', name: 'Brazil', dial: '+55', flag: '🇧🇷', regex: /^[1-9]{2}9?\d{8}$/, placeholder: '11 91234 5678' },
  { code: 'CA', name: 'Canada', dial: '+1', flag: '🇨🇦', regex: /^\d{10}$/, placeholder: '416 555 0123' }
];

function initProjectEnquiryForm() {
  const form = document.getElementById('project-enquiry-form');
  if (!form) return;

  // Selected state
  let selectedCountry = WORLD_COUNTRIES[0]; // Default India
  let uploadedFilesList = [];

  // DOM Elements
  const countryBtn = document.getElementById('enquiry-country-btn');
  const countryDropdown = document.getElementById('enquiry-country-dropdown');
  const countryCodeInput = document.getElementById('enquiry-country-code');
  const countryFlagEl = document.getElementById('selected-country-flag');
  const countryDialEl = document.getElementById('selected-country-dial');
  const countrySearch = document.getElementById('country-search-input');
  const countryListEl = document.getElementById('country-options-list');
  const phoneInput = document.getElementById('enquiry-phone');

  // File Upload Elements
  const dropZone = document.getElementById('enquiry-drop-zone');
  const fileInput = document.getElementById('enquiry-file-input');
  const fileListContainer = document.getElementById('enquiry-files-preview');

  // 1. Populate Country Dropdown
  function renderCountryList(filter = '') {
    if (!countryListEl) return;
    countryListEl.innerHTML = '';
    const filtered = WORLD_COUNTRIES.filter(c => 
      c.name.toLowerCase().includes(filter.toLowerCase()) || 
      c.dial.includes(filter) ||
      c.code.toLowerCase().includes(filter.toLowerCase())
    );

    filtered.forEach(c => {
      const item = document.createElement('div');
      item.className = `country-option-item ${c.code === selectedCountry.code ? 'active' : ''}`;
      item.innerHTML = `
        <span class="country-opt-flag">${c.flag}</span>
        <span class="country-opt-name">${c.name}</span>
        <span class="country-opt-dial">${c.dial}</span>
      `;
      item.addEventListener('click', () => {
        selectCountry(c);
        closeCountryDropdown();
      });
      countryListEl.appendChild(item);
    });
  }

  function selectCountry(c) {
    selectedCountry = c;
    countryCodeInput.value = c.dial;
    countryFlagEl.textContent = c.flag;
    countryDialEl.textContent = c.dial;
    phoneInput.placeholder = c.placeholder || 'Enter phone number';
    validateField(phoneInput);
  }

  function openCountryDropdown() {
    countryDropdown.classList.add('open');
    countryBtn.setAttribute('aria-expanded', 'true');
    if (countrySearch) {
      countrySearch.value = '';
      renderCountryList('');
      setTimeout(() => countrySearch.focus(), 50);
    }
  }

  function closeCountryDropdown() {
    countryDropdown.classList.remove('open');
    countryBtn.setAttribute('aria-expanded', 'false');
  }

  if (countryBtn) {
    countryBtn.addEventListener('click', (e) => {
      e.stopPropagation();
      if (countryDropdown.classList.contains('open')) {
        closeCountryDropdown();
      } else {
        openCountryDropdown();
      }
    });

    if (countrySearch) {
      countrySearch.addEventListener('input', (e) => {
        renderCountryList(e.target.value);
      });
    }

    document.addEventListener('click', (e) => {
      if (!countryDropdown.contains(e.target) && !countryBtn.contains(e.target)) {
        closeCountryDropdown();
      }
    });

    renderCountryList('');
  }

  // 2. Field Validations
  const fields = {
    name: document.getElementById('enquiry-name'),
    company: document.getElementById('enquiry-company'),
    email: document.getElementById('enquiry-email'),
    phone: document.getElementById('enquiry-phone'),
    projectType: document.getElementById('enquiry-project-type'),
    product: document.getElementById('enquiry-product'),
    startDate: document.getElementById('enquiry-start-date'),
    message: document.getElementById('enquiry-message')
  };

  function setFieldError(input, msg) {
    if (!input) return;
    const group = input.closest('.form-group');
    if (group) {
      group.classList.add('has-error');
      group.classList.remove('is-valid');
      let errEl = group.querySelector('.field-error-msg');
      if (!errEl) {
        errEl = document.createElement('span');
        errEl.className = 'field-error-msg';
        group.appendChild(errEl);
      }
      errEl.textContent = msg;
    }
  }

  function clearFieldError(input) {
    if (!input) return;
    const group = input.closest('.form-group');
    if (group) {
      group.classList.remove('has-error');
      group.classList.add('is-valid');
      const errEl = group.querySelector('.field-error-msg');
      if (errEl) errEl.textContent = '';
    }
  }

  function validateField(input) {
    if (!input) return true;
    const val = input.value.trim();

    if (input === fields.name) {
      if (!val) {
        setFieldError(input, 'Full name is required');
        return false;
      }
      if (val.length < 2) {
        setFieldError(input, 'Name must be at least 2 characters');
        return false;
      }
      clearFieldError(input);
      return true;
    }

    if (input === fields.company) {
      if (!val) {
        setFieldError(input, 'Company name is required');
        return false;
      }
      clearFieldError(input);
      return true;
    }

    if (input === fields.email) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!val) {
        setFieldError(input, 'Email address is required');
        return false;
      }
      if (!emailRegex.test(val)) {
        setFieldError(input, 'Please enter a valid email address');
        return false;
      }
      clearFieldError(input);
      return true;
    }

    if (input === fields.phone) {
      const clean = val.replace(/[\s\-\(\)]/g, '');
      if (!val) {
        setFieldError(input, 'Mobile number is required');
        return false;
      }
      if (selectedCountry.regex && !selectedCountry.regex.test(clean)) {
        setFieldError(input, `Please enter a valid number for ${selectedCountry.name}`);
        return false;
      }
      if (clean.length < 6 || clean.length > 15) {
        setFieldError(input, 'Invalid phone number length');
        return false;
      }
      clearFieldError(input);
      return true;
    }

    if (input === fields.projectType) {
      if (!val) {
        setFieldError(input, 'Please select a project type');
        return false;
      }
      clearFieldError(input);
      return true;
    }

    if (input === fields.product) {
      if (!val) {
        setFieldError(input, 'Please select a product/solution');
        return false;
      }
      clearFieldError(input);
      return true;
    }

    if (input === fields.startDate && val) {
      const chosen = new Date(val);
      const today = new Date();
      today.setHours(0, 0, 0, 0);
      if (chosen < today) {
        setFieldError(input, 'Start date cannot be in the past');
        return false;
      }
      clearFieldError(input);
      return true;
    }

    if (input === fields.message) {
      if (!val) {
        setFieldError(input, 'Please describe your requirement');
        return false;
      }
      if (val.length < 10) {
        setFieldError(input, 'Please enter at least 10 characters');
        return false;
      }
      clearFieldError(input);
      return true;
    }

    return true;
  }

  // Attach live blur & input listeners
  Object.values(fields).forEach(input => {
    if (!input) return;
    input.addEventListener('blur', () => validateField(input));
    input.addEventListener('input', () => {
      const group = input.closest('.form-group');
      if (group && group.classList.contains('has-error')) {
        validateField(input);
      }
    });
  });

  // 3. File Drag & Drop + Upload Preview
  const ALLOWED_TYPES = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'image/jpeg', 'image/png'];
  const MAX_FILE_BYTES = 10 * 1024 * 1024; // 10MB

  function formatBytes(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(1)) + ' ' + sizes[i];
  }

  function renderFileList() {
    if (!fileListContainer) return;
    fileListContainer.innerHTML = '';
    
    if (uploadedFilesList.length === 0) {
      fileListContainer.style.display = 'none';
      return;
    }

    fileListContainer.style.display = 'flex';
    uploadedFilesList.forEach((file, index) => {
      const chip = document.createElement('div');
      chip.className = 'uploaded-file-chip';
      chip.innerHTML = `
        <div class="file-chip-info">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
            <polyline points="14 2 14 8 20 8"/>
          </svg>
          <span class="file-chip-name">${file.name}</span>
          <span class="file-chip-size">(${formatBytes(file.size)})</span>
        </div>
        <button type="button" class="btn-remove-file" title="Remove file" aria-label="Remove file">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
      `;

      chip.querySelector('.btn-remove-file').addEventListener('click', (e) => {
        e.stopPropagation();
        uploadedFilesList.splice(index, 1);
        renderFileList();
      });

      fileListContainer.appendChild(chip);
    });
  }

  function handleFiles(files) {
    const errorContainer = document.getElementById('enquiry-file-error');
    if (errorContainer) errorContainer.textContent = '';

    for (let i = 0; i < files.length; i++) {
      const file = files[i];
      const ext = file.name.split('.').pop().toLowerCase();
      const validExts = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png'];

      if (!validExts.includes(ext)) {
        if (errorContainer) errorContainer.textContent = `File "${file.name}" has an invalid extension. Only PDF, DOC, DOCX, JPG, PNG allowed.`;
        return;
      }

      if (file.size > MAX_FILE_BYTES) {
        if (errorContainer) errorContainer.textContent = `File "${file.name}" exceeds 10MB limit.`;
        return;
      }

      // Check duplicates
      const exists = uploadedFilesList.some(f => f.name === file.name && f.size === file.size);
      if (!exists) {
        uploadedFilesList.push(file);
      }
    }

    renderFileList();
  }

  if (dropZone && fileInput) {
    dropZone.addEventListener('click', () => fileInput.click());

    fileInput.addEventListener('change', (e) => {
      if (e.target.files.length) {
        handleFiles(e.target.files);
        fileInput.value = '';
      }
    });

    ['dragenter', 'dragover'].forEach(eventName => {
      dropZone.addEventListener(eventName, (e) => {
        e.preventDefault();
        e.stopPropagation();
        dropZone.classList.add('drag-over');
      });
    });

    ['dragleave', 'drop'].forEach(eventName => {
      dropZone.addEventListener(eventName, (e) => {
        e.preventDefault();
        e.stopPropagation();
        dropZone.classList.remove('drag-over');
      });
    });

    dropZone.addEventListener('drop', (e) => {
      const dt = e.dataTransfer;
      if (dt.files && dt.files.length) {
        handleFiles(dt.files);
      }
    });
  }

  // 4. Form Submit Handler (AJAX)
  const submitBtn = document.getElementById('btn-submit-enquiry');
  const formStatusMsg = document.getElementById('enquiry-form-status');

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    // Validate all fields
    let isValid = true;
    Object.values(fields).forEach(input => {
      if (!validateField(input)) {
        isValid = false;
      }
    });

    if (!isValid) {
      if (formStatusMsg) {
        formStatusMsg.className = 'enquiry-status-msg error';
        formStatusMsg.textContent = 'Please fill all required fields correctly before submitting.';
      }
      const firstErr = form.querySelector('.has-error input, .has-error select, .has-error textarea');
      if (firstErr) firstErr.focus();
      return;
    }

    // Build FormData
    const formData = new FormData(form);
    formData.set('country_code', selectedCountry.dial);

    // Append uploaded files
    uploadedFilesList.forEach((file) => {
      formData.append('documents[]', file);
    });

    // Loading UI state
    submitBtn.disabled = true;
    const originalBtnHTML = submitBtn.innerHTML;
    submitBtn.innerHTML = `
      <span class="btn-spinner"></span>
      <span>SUBMITTING ENQUIRY...</span>
    `;
    if (formStatusMsg) {
      formStatusMsg.className = 'enquiry-status-msg';
      formStatusMsg.textContent = '';
    }

    try {
      const response = await fetch('enquiry.php', {
        method: 'POST',
        body: formData
      });

      const data = await response.json();

      submitBtn.disabled = false;
      submitBtn.innerHTML = originalBtnHTML;

      if (data.success) {
        if (formStatusMsg) {
          formStatusMsg.className = 'enquiry-status-msg success';
          formStatusMsg.textContent = data.message || 'Thank you! Your project enquiry has been submitted successfully. Our marine engineering team will review your specifications and get in touch within 24 hours.';
        }
        form.reset();
        uploadedFilesList = [];
        renderFileList();
        selectCountry(WORLD_COUNTRIES[0]);
        Object.values(fields).forEach(f => {
          if (f) {
            const grp = f.closest('.form-group');
            if (grp) {
              grp.classList.remove('has-error', 'is-valid');
              const errEl = grp.querySelector('.field-error-msg');
              if (errEl) errEl.textContent = '';
            }
          }
        });
      } else {
        if (formStatusMsg) {
          formStatusMsg.className = 'enquiry-status-msg error';
          formStatusMsg.textContent = data.message || 'Submission failed. Please try again.';
        }
      }
    } catch (err) {
      console.error('Enquiry submission error:', err);
      submitBtn.disabled = false;
      submitBtn.innerHTML = originalBtnHTML;
      if (formStatusMsg) {
        formStatusMsg.className = 'enquiry-status-msg error';
        formStatusMsg.textContent = 'Server connection error. Please check your network and try again.';
      }
    }
  });
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', initProjectEnquiryForm);
} else {
  initProjectEnquiryForm();
}
