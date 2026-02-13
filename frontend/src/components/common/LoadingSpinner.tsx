import React from 'react';

export const LoadingSpinner: React.FC = () => {
  return (
    <div className="d-flex flex-column align-items-center justify-content-center p-5">
      <div className="spinner-border text-primary" role="status">
        <span className="visually-hidden">Chargement...</span>
      </div>
      <p className="mt-3 text-muted">Chargement...</p>
    </div>
  );
};
