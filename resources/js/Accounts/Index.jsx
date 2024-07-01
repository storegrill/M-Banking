// Accounts/Index.jsx

import React from 'react';
import { usePage } from '@inertiajs/inertia-react';

const Index = () => {
  const { accounts } = usePage().props;

  return (
    <div>
      <h1>Accounts</h1>
      <ul>
        {accounts.map(account => (
          <li key={account.id}>
            {account.account_number} - Balance: {account.balance}
          </li>
        ))}
      </ul>
    </div>
  );
};

export default Index;
