import axios from 'axios';

export const testApiConnection = async () => {
  try {
    // Health check
    const healthResponse = await axios.get('/api/health');
    console.log('Health check:', healthResponse.data);

    // Endpoints check
    const endpointsResponse = await axios.get('/api/test/endpoints');
    console.log('Available endpoints:', endpointsResponse.data);

    // Database check
    const dbResponse = await axios.get('/api/test/database');
    console.log('Database status:', dbResponse.data);

    return {
      status: 'success',
      health: healthResponse.data,
      endpoints: endpointsResponse.data,
      database: dbResponse.data
    };
  } catch (error) {
    console.error('API Connection Test Failed:', error);
    return {
      status: 'error',
      message: error.message,
      error
    };
  }
};
