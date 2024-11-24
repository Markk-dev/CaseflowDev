class AccountSettings {
    constructor(userData) {
        this.userData = userData;  // User data passed from the backend
        this.accountSettingsSection = document.getElementById('accountSettingsSection');
        this.backToSettingsBtn = this.accountSettingsSection.querySelector('#backToSettings');
    }

    populateAccountSettings() {
        const { fname, lname, email } = this.userData;

        this.accountSettingsSection.innerHTML = `
            <h5>Your Profile</h5>
            <p><strong>Name:</strong> ${fname} ${lname}</p>
            <p><strong>Email:</strong> ${email}</p>
            <p><strong>Total Cases Participated:</strong> Placeholder</p>
            <button class="btn btn-sm btn-secondary mt-2" id="backToSettings">Back to Settings</button>
            <hr>
            <h5>Manage Account</h5>
            <button class="btn btn-sm btn-primary mt-2">Change Password</button>
            <button class="btn btn-sm btn-primary mt-2">Update Profile Picture</button>
            <button class="btn btn-sm btn-primary mt-2">Configure Email Preferences</button>
        `;

        this.backToSettingsBtn = this.accountSettingsSection.querySelector('#backToSettings');
        this.addBackToSettingsEvent();
    }

    showAccountSettings() {
        document.getElementById('settingsSection').classList.remove('active');
        this.accountSettingsSection.classList.add('active');
    }

    addBackToSettingsEvent() {
        this.backToSettingsBtn.addEventListener('click', () => {
            this.accountSettingsSection.classList.remove('active');
            document.getElementById('settingsSection').classList.add('active');
        });
    }
}


// Initialize the tabs and load user data
document.addEventListener('DOMContentLoaded', async () => {
    const accountSettingsTab = document.getElementById('accountSettingsTab');
    const userData = await fetchUserData();

    const accountSettings = new AccountSettings(userData);

    accountSettingsTab.addEventListener('click', () => {
        accountSettings.populateAccountSettings();
        accountSettings.showAccountSettings();
    });
});

// Mock function to simulate fetching user data
async function fetchUserData() {
    const response = await fetch('/user/getUserData');  // Updated to a valid URL string
    const data = await response.json();
    return data;
}
