// Accounts/Create.jsx

import React, { useState } from 'react';
import { useForm } from '@inertiajs/inertia-react';

const Create = () => {
  const [accountNumber, setAccountNumber] = useState('');
  const { post, errors } = useForm();

  const handleSubmit = (e) => {
    e.preventDefault();
    post('/accounts', {
      account_number: accountNumber,
    });
  };

  return (
    <div>
      <h1>Create Account</h1>
      <form onSubmit={handleSubmit}>
        <div>
          <label>Account Number:</label>
          <input
            type="text"
            value={accountNumber}
            onChange={(e) => setAccountNumber(e.target.value)}
          />
          {errors.account_number && (
            <div className="text-red-500">{errors.account_number}</div>
          )}
        </div>
        <button type="submit">Create Account</button>
      </form>
    </div>
  );
};

export default Create;
