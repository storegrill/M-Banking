// Accounts/Transfer.jsx

import React, { useState } from 'react';
import { useForm } from '@inertiajs/inertia-react';

const Transfer = () => {
  const [fromAccount, setFromAccount] = useState('');
  const [toAccount, setToAccount] = useState('');
  const [amount, setAmount] = useState('');
  const { post, errors } = useForm();

  const handleSubmit = (e) => {
    e.preventDefault();
    post('/accounts/transfer', {
      from_account: fromAccount,
      to_account: toAccount,
      amount: amount,
    });
  };

  return (
    <div>
      <h1>Transfer Money</h1>
      <form onSubmit={handleSubmit}>
        <div>
          <label>From Account:</label>
          <input
            type="text"
            value={fromAccount}
            onChange={(e) => setFromAccount(e.target.value)}
          />
          {errors.from_account && (
            <div className="text-red-500">{errors.from_account}</div>
          )}
        </div>
        <div>
          <label>To Account:</label>
          <input
            type="text"
            value={toAccount}
            onChange={(e) => setToAccount(e.target.value)}
          />
          {errors.to_account && (
            <div className="text-red-500">{errors.to_account}</div>
          )}
        </div>
        <div>
          <label>Amount:</label>
          <input
            type="number"
            value={amount}
            onChange={(e) => setAmount(e.target.value)}
          />
          {errors.amount && (
            <div className="text-red-500">{errors.amount}</div>
          )}
        </div>
        <button type="submit">Transfer</button>
      </form>
    </div>
  );
};

export default Transfer;
