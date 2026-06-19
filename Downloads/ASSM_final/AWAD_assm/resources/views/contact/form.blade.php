<div class="contact-form">
    <h2>Send Us a Message</h2>
    
    @if(session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif
    
    <form method="POST" action="{{ route('contact.store') }}">
        @csrf
        
        <div class="form-group">
            <label for="name">Your Name *</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" class="@error('name') invalid @enderror">
            @error('name') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        
        <div class="form-group">
            <label for="email">Email Address *</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" class="@error('email') invalid @enderror">
            @error('email') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        
        <div class="form-group">
            <label for="order_id">Order ID (if applicable)</label>
            <input type="text" id="order_id" name="order_id" value="{{ old('order_id') }}">
        </div>
        
        <div class="form-group">
            <label for="query_type">Query Type *</label>
            <select id="query_type" name="query_type" class="@error('query_type') invalid @enderror">
                <option value="" {{ old('query_type') == '' ? 'selected' : '' }}>Select a query type</option>
                <option value="order_status" {{ old('query_type') == 'order_status' ? 'selected' : '' }}>Order Status</option>
                <option value="food_quality" {{ old('query_type') == 'food_quality' ? 'selected' : '' }}>Food Quality</option>
                <option value="refund_request" {{ old('query_type') == 'refund_request' ? 'selected' : '' }}>Refund Request</option>
                <option value="menu_inquiry" {{ old('query_type') == 'menu_inquiry' ? 'selected' : '' }}>Menu Inquiry</option>
                <option value="other" {{ old('query_type') == 'other' ? 'selected' : '' }}>Other</option>
            </select>
            <small id="query-hint" class="form-hint"></small>
            @error('query_type') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        
        <div class="form-group">
            <label for="message">Your Message *</label>
            <textarea id="message" name="message" class="@error('message') invalid @enderror">{{ old('message') }}</textarea>
            @error('message') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        
        <button type="submit" class="btn-submit">
            Send Message
        </button>
    </form>
</div>

<script>
    const form = document.querySelector('.contact-form form');
    const requiredFields = [
        { id: 'name', error: 'Name is required' },
        { id: 'email', error: 'Email is required' },
        { id: 'query_type', error: 'Please select a query type' },
        { id: 'message', error: 'Message is required' }
    ];

    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        document.querySelectorAll('.field-error').forEach(el => el.textContent = '');
        document.querySelectorAll('input, select, textarea').forEach(el => el.classList.remove('invalid'));

        requiredFields.forEach(field => {
            const element = document.getElementById(field.id);
            const value = element.value.trim();
            
            if (value === '' || (field.id === 'query_type' && value === '')) {
                document.querySelector(`#${field.id}`).nextElementSibling.textContent = field.error;
                element.classList.add('invalid');
                isValid = false;
            }
        });

        const email = document.getElementById('email').value.trim();
        if (email !== '') {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                document.getElementById('email').nextElementSibling.textContent = 'Please enter a valid email address';
                document.getElementById('email').classList.add('invalid');
                isValid = false;
            }
        }

        if (!isValid) {
            e.preventDefault(); 
            return false;
        }
    });

    document.querySelectorAll('input, textarea, select').forEach(element => {
        element.addEventListener('input', function() {
            this.classList.remove('invalid');
            this.nextElementSibling.textContent = '';
        });
    });

    document.getElementById('query_type').addEventListener('change', function() {
        const hintEl = document.getElementById('query-hint');
        const hints = {
            'order_status': 'Please include your order time for faster processing',
            'food_quality': 'Please describe the issue with specific menu items'
        };
        hintEl.textContent = hints[this.value] || '';
    });
</script>